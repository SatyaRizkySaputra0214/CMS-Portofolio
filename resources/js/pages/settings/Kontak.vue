<script setup lang="ts">
import { Head, router, useForm } from '@inertiajs/vue3';
import { ref } from 'vue';
import { index as indexKontak } from '@/routes/kontak';
import {
    store as storeKontak,
    update as updateKontak,
    destroy as destroyKontak,
} from '@/routes/kontak';
import Heading from '@/components/Heading.vue';
import InputError from '@/components/InputError.vue';
import { Button } from '@/components/ui/button';
import { Input } from '@/components/ui/input';
import { Label } from '@/components/ui/label';
import { Share2 } from '@lucide/vue';
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
                title: 'Tautan Kontak',
                href: indexKontak(),
            },
        ],
    },
});

interface KontakItem {
    id: number;
    platform: string;
    url: string;
    ikon: string | null;
}

const props = defineProps<{
    kontak: KontakItem[];
}>();

const isDialogOpen = ref(false);
const isEditing = ref(false);
const currentId = ref<number | null>(null);

const form = useForm({
    platform: 'LinkedIn',
    url: '',
    ikon: '',
});

const openAddDialog = () => {
    isEditing.value = false;
    currentId.value = null;
    form.reset();
    form.clearErrors();
    isDialogOpen.value = true;
};

const openEditDialog = (item: KontakItem) => {
    isEditing.value = true;
    currentId.value = item.id;
    form.clearErrors();
    form.platform = item.platform;
    form.url = item.url;
    form.ikon = item.ikon || '';
    isDialogOpen.value = true;
};

const handlePlatformChange = () => {
    // Automatically set default icon class based on platform
    const platformLower = form.platform.toLowerCase();
    if (platformLower === 'linkedin') {
        form.ikon = 'linkedin';
    } else if (platformLower === 'github') {
        form.ikon = 'github';
    } else if (platformLower === 'email') {
        form.ikon = 'mail';
    } else {
        form.ikon = 'link';
    }
};

const submitForm = () => {
    if (isEditing.value && currentId.value) {
        form.put(updateKontak.url(currentId.value), {
            onSuccess: () => {
                isDialogOpen.value = false;
                form.reset();
            },
        });
    } else {
        form.post(storeKontak.url(), {
            onSuccess: () => {
                isDialogOpen.value = false;
                form.reset();
            },
        });
    }
};

const deleteItem = (id: number) => {
    if (confirm('Apakah Anda yakin ingin menghapus data kontak ini?')) {
        router.delete(destroyKontak.url(id));
    }
};
</script>

<template>
    <Head title="Tautan Kontak" />
    <h1 class="sr-only">Tautan Kontak</h1>

    <div class="flex flex-col space-y-6 p-6 sm:p-8">
        <div
            class="flex flex-col justify-between gap-4 sm:flex-row sm:items-center"
        >
            <Heading
                variant="small"
                title="Tautan Kontak"
                description="Kelola media sosial dan tautan hubungi saya yang akan ditampilkan di footer publik."
            />
            <Button @click="openAddDialog" class="w-fit shrink-0"
                >Tambah Kontak</Button
            >
        </div>

        <!-- List Kontak -->
        <div class="space-y-4">
            <div
                v-if="kontak.length === 0"
                class="rounded-xl border-2 border-dashed border-neutral-200 p-10 text-center text-muted-foreground sm:p-12 dark:border-neutral-700"
            >
                <div class="flex flex-col items-center gap-2">
                    <Share2
                        class="h-8 w-8 text-neutral-300 dark:text-neutral-600"
                    />
                    <p>Belum ada data kontak. Silakan tambahkan data baru.</p>
                </div>
            </div>

            <div
                v-for="item in kontak"
                :key="item.id"
                class="flex flex-col justify-between gap-4 rounded-xl border p-5 shadow-sm transition-all hover:bg-neutral-50/50 hover:shadow-md sm:p-6 md:flex-row md:items-center dark:hover:bg-neutral-900/50"
            >
                <div class="space-y-1.5">
                    <div class="flex items-center gap-2">
                        <h3 class="text-base font-semibold">
                            {{ item.platform }}
                        </h3>
                        <span
                            class="rounded-md bg-slate-100 px-2.5 py-1 text-xs font-medium text-muted-foreground dark:bg-neutral-800"
                        >
                            {{ item.ikon || 'Default' }}
                        </span>
                    </div>
                    <a
                        :href="item.url"
                        target="_blank"
                        class="text-sm font-medium break-all text-blue-600 transition-colors hover:text-blue-500"
                        >{{ item.url }}</a
                    >
                </div>
                <div class="flex shrink-0 items-center gap-2">
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

        <!-- Dialog Modal Form -->
        <Dialog :open="isDialogOpen" @update:open="isDialogOpen = $event">
            <DialogContent class="sm:max-w-[450px]">
                <form @submit.prevent="submitForm" class="space-y-5">
                    <DialogHeader>
                        <DialogTitle>{{
                            isEditing ? 'Edit Kontak' : 'Tambah Kontak'
                        }}</DialogTitle>
                        <DialogDescription>
                            Isi form di bawah ini untuk
                            {{ isEditing ? 'memperbarui' : 'menambahkan' }}
                            tautan kontak Anda.
                        </DialogDescription>
                    </DialogHeader>

                    <div class="space-y-5">
                        <div class="grid gap-2">
                            <Label for="platform">Platform Kontak</Label>
                            <select
                                id="platform"
                                v-model="form.platform"
                                @change="handlePlatformChange"
                                required
                                class="flex h-9 w-full rounded-md border border-input bg-transparent px-3 py-1 text-sm shadow-xs transition-colors outline-none focus-visible:border-ring focus-visible:ring-1 focus-visible:ring-ring disabled:cursor-not-allowed disabled:opacity-50 dark:bg-input/30"
                            >
                                <option value="LinkedIn">LinkedIn</option>
                                <option value="GitHub">GitHub</option>
                                <option value="Email">Email</option>
                                <option value="Twitter">Twitter / X</option>
                                <option value="Instagram">Instagram</option>
                                <option value="Website">
                                    Personal Website / Lainnya
                                </option>
                            </select>
                            <InputError :message="form.errors.platform" />
                        </div>

                        <div class="grid gap-2">
                            <Label for="url">URL Tautan / Email Address</Label>
                            <Input
                                id="url"
                                v-model="form.url"
                                required
                                placeholder="Contoh: https://linkedin.com/in/nama, atau mailto:admin@email.com"
                            />
                            <InputError :message="form.errors.url" />
                        </div>

                        <div class="grid gap-2">
                            <Label for="ikon">Ikon Class / Identifier</Label>
                            <Input
                                id="ikon"
                                v-model="form.ikon"
                                placeholder="linkedin, github, mail, link, dll."
                            />
                            <InputError :message="form.errors.ikon" />
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
