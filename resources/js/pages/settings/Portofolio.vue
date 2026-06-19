<script setup lang="ts">
import { Head, router, useForm } from '@inertiajs/vue3';
import { ref } from 'vue';
import { index as indexPortofolio } from '@/routes/portofolio';
import {
    store as storePortofolio,
    update as updatePortofolio,
    destroy as destroyPortofolio,
} from '@/routes/portofolio';
import Heading from '@/components/Heading.vue';
import InputError from '@/components/InputError.vue';
import { Button } from '@/components/ui/button';
import { Input } from '@/components/ui/input';
import { Label } from '@/components/ui/label';
import { Textarea } from '@/components/ui/textarea';
import { FolderGit2 } from '@lucide/vue';
import {
    Dialog,
    DialogContent,
    DialogDescription,
    DialogFooter,
    DialogHeader,
    DialogTitle,
} from '@/components/ui/dialog';

defineOptions({
    layout: {
        breadcrumbs: [
            {
                title: 'Galeri Portofolio',
                href: indexPortofolio(),
            },
        ],
    },
});

interface PortofolioItem {
    id: number;
    judul_proyek: string;
    thumbnail: string | null;
    deskripsi_singkat: string;
    deskripsi_lengkap: string | null;
    link_eksternal: string | null;
    tools: string[] | null;
}

const props = defineProps<{
    portofolio: PortofolioItem[];
}>();

const isDialogOpen = ref(false);
const isEditing = ref(false);
const currentId = ref<number | null>(null);

const form = useForm({
    judul_proyek: '',
    thumbnail: null as File | null,
    deskripsi_singkat: '',
    deskripsi_lengkap: '',
    link_eksternal: '',
    tools: '',
});

const openAddDialog = () => {
    isEditing.value = false;
    currentId.value = null;
    form.reset();
    form.clearErrors();
    isDialogOpen.value = true;
};

const openEditDialog = (item: PortofolioItem) => {
    isEditing.value = true;
    currentId.value = item.id;
    form.clearErrors();
    form.judul_proyek = item.judul_proyek;
    form.thumbnail = null; // Don't prefill file input
    form.deskripsi_singkat = item.deskripsi_singkat;
    form.deskripsi_lengkap = item.deskripsi_lengkap || '';
    form.link_eksternal = item.link_eksternal || '';
    form.tools = item.tools?.join(', ') || '';
    isDialogOpen.value = true;
};

const handleFileChange = (e: Event) => {
    const target = e.target as HTMLInputElement;
    if (target.files && target.files.length > 0) {
        form.thumbnail = target.files[0];
    }
};

const submitForm = () => {
    if (isEditing.value && currentId.value) {
        form.post(updatePortofolio.url(currentId.value), {
            onSuccess: () => {
                isDialogOpen.value = false;
                form.reset();
            },
        });
    } else {
        form.post(storePortofolio.url(), {
            onSuccess: () => {
                isDialogOpen.value = false;
                form.reset();
            },
        });
    }
};

const deleteItem = (id: number) => {
    if (confirm('Apakah Anda yakin ingin menghapus data proyek ini?')) {
        router.delete(destroyPortofolio.url(id));
    }
};
</script>

<template>
    <Head title="Galeri Portofolio" />
    <h1 class="sr-only">Galeri Portofolio</h1>

    <div class="flex flex-col space-y-6 p-6 sm:p-8">
        <div
            class="flex flex-col justify-between gap-4 sm:flex-row sm:items-center"
        >
            <Heading
                variant="small"
                title="Galeri Portofolio"
                description="Kelola proyek, aplikasi, atau karya yang ingin Anda tunjukkan di portofolio."
            />
            <Button @click="openAddDialog" class="w-fit shrink-0"
                >Tambah Proyek</Button
            >
        </div>

        <!-- Grid Portofolio -->
        <div class="grid gap-5 sm:gap-6 md:grid-cols-2">
            <div
                v-if="portofolio.length === 0"
                class="col-span-full rounded-xl border-2 border-dashed border-neutral-200 p-10 text-center text-muted-foreground sm:p-12 dark:border-neutral-700"
            >
                <div class="flex flex-col items-center gap-2">
                    <FolderGit2
                        class="h-8 w-8 text-neutral-300 dark:text-neutral-600"
                    />
                    <p>
                        Belum ada data proyek portofolio. Silakan tambahkan
                        proyek baru.
                    </p>
                </div>
            </div>

            <div
                v-for="item in portofolio"
                :key="item.id"
                class="flex flex-col overflow-hidden rounded-xl border shadow-sm transition-all hover:shadow-md dark:bg-neutral-900/10"
            >
                <div
                    class="flex aspect-video w-full items-center justify-center overflow-hidden border-b bg-neutral-100 dark:bg-neutral-800"
                >
                    <img
                        v-if="item.thumbnail"
                        :src="`/storage/${item.thumbnail}`"
                        alt="Thumbnail proyek"
                        class="h-full w-full object-cover transition-transform duration-500 hover:scale-110"
                    />
                    <div v-else class="text-xs text-muted-foreground italic">
                        <div class="flex flex-col items-center gap-1">
                            <FolderGit2
                                class="h-6 w-6 text-neutral-300 dark:text-neutral-600"
                            />
                            <span>Tidak ada gambar pratinjau</span>
                        </div>
                    </div>
                </div>
                <div class="flex flex-1 flex-col space-y-3 p-5 sm:p-6">
                    <div class="space-y-1.5">
                        <h3
                            class="line-clamp-1 text-base leading-tight font-semibold"
                        >
                            {{ item.judul_proyek }}
                        </h3>
                        <p
                            class="line-clamp-2 text-sm leading-relaxed text-neutral-500"
                        >
                            {{ item.deskripsi_singkat }}
                        </p>
                    </div>
                    <div class="flex-1"></div>
                    <div
                        class="flex items-center justify-between border-t border-neutral-100 pt-2 dark:border-neutral-800"
                    >
                        <a
                            v-if="item.link_eksternal"
                            :href="item.link_eksternal"
                            target="_blank"
                            class="text-xs font-medium text-blue-600 transition-colors hover:text-blue-500"
                        >
                            Tautan Demo/Repository
                        </a>
                        <span
                            v-else
                            class="text-xs text-muted-foreground italic"
                            >Tidak ada tautan</span
                        >
                        <div class="flex items-center gap-1.5">
                            <Button
                                variant="outline"
                                size="sm"
                                @click="openEditDialog(item)"
                                >Edit</Button
                            >
                            <Button
                                variant="destructive"
                                size="sm"
                                @click="deleteItem(item.id)"
                                >Hapus</Button
                            >
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Dialog Modal Form -->
        <Dialog :open="isDialogOpen" @update:open="isDialogOpen = $event">
            <DialogContent class="sm:max-w-[500px]">
                <form @submit.prevent="submitForm" class="space-y-5">
                    <DialogHeader>
                        <DialogTitle>{{
                            isEditing ? 'Edit Proyek' : 'Tambah Proyek'
                        }}</DialogTitle>
                        <DialogDescription>
                            Isi form di bawah ini untuk
                            {{ isEditing ? 'memperbarui' : 'menambahkan' }}
                            proyek portofolio Anda.
                        </DialogDescription>
                    </DialogHeader>

                    <div class="space-y-5">
                        <div class="grid gap-2">
                            <Label for="judul_proyek">Judul Proyek</Label>
                            <Input
                                id="judul_proyek"
                                v-model="form.judul_proyek"
                                required
                                placeholder="Contoh: E-Commerce Mobile App"
                            />
                            <InputError :message="form.errors.judul_proyek" />
                        </div>

                        <div class="grid gap-2">
                            <Label for="thumbnail"
                                >Gambar Thumbnail
                                <span class="font-normal text-muted-foreground"
                                    >(Max 2MB)</span
                                ></Label
                            >
                            <Input
                                id="thumbnail"
                                type="file"
                                @change="handleFileChange"
                                accept="image/*"
                            />
                            <p class="text-xs text-muted-foreground">
                                Kosongkan jika tidak ingin mengubah thumbnail.
                            </p>
                            <InputError :message="form.errors.thumbnail" />
                        </div>

                        <div class="grid gap-2">
                            <Label for="deskripsi_singkat"
                                >Deskripsi Singkat
                                <span class="font-normal text-muted-foreground"
                                    >(Max 255 karakter)</span
                                ></Label
                            >
                            <Input
                                id="deskripsi_singkat"
                                v-model="form.deskripsi_singkat"
                                required
                                maxlength="255"
                                placeholder="Tulis ringkasan 1-2 kalimat..."
                            />
                            <InputError
                                :message="form.errors.deskripsi_singkat"
                            />
                        </div>

                        <div class="grid gap-2">
                            <Label for="deskripsi_lengkap"
                                >Detail Lengkap Proyek</Label
                            >
                            <Textarea
                                id="deskripsi_lengkap"
                                v-model="form.deskripsi_lengkap"
                                placeholder="Tuliskan latar belakang, fitur, dan teknologi yang digunakan..."
                                class="min-h-[120px]"
                            />
                            <InputError
                                :message="form.errors.deskripsi_lengkap"
                            />
                        </div>

                        <div class="grid gap-2">
                            <Label for="tools"
                                >Tools / Teknologi
                                <span class="font-normal text-muted-foreground"
                                    >(Pisahkan dengan koma)</span
                                ></Label
                            >
                            <Input
                                id="tools"
                                v-model="form.tools"
                                placeholder="Vue.js, React, Tailwind CSS"
                            />
                            <InputError :message="form.errors.tools" />
                        </div>

                        <div class="grid gap-2">
                            <Label for="link_eksternal"
                                >Tautan Eksternal (GitHub/Demo)</Label
                            >
                            <Input
                                id="link_eksternal"
                                v-model="form.link_eksternal"
                                placeholder="https://github.com/username/project"
                            />
                            <InputError :message="form.errors.link_eksternal" />
                        </div>
                    </div>

                    <DialogFooter class="pt-2">
                        <Button
                            type="button"
                            variant="outline"
                            @click="isDialogOpen = false"
                            >Batal</Button
                        >
                        <Button type="submit" :disabled="form.processing"
                            >Simpan</Button
                        >
                    </DialogFooter>
                </form>
            </DialogContent>
        </Dialog>
    </div>
</template>
