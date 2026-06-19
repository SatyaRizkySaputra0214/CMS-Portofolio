<script setup lang="ts">
import { Head, router, useForm } from '@inertiajs/vue3';
import { ref, computed } from 'vue';
import { index as indexSkills } from '@/routes/skills';
import {
    store as storeSkills,
    update as updateSkills,
    destroy as destroySkills,
} from '@/routes/skills';
import Heading from '@/components/Heading.vue';
import InputError from '@/components/InputError.vue';
import { Button } from '@/components/ui/button';
import { Input } from '@/components/ui/input';
import { Label } from '@/components/ui/label';
import {
    Dialog,
    DialogContent,
    DialogDescription,
    DialogFooter,
    DialogHeader,
    DialogTitle,
} from '@/components/ui/dialog';
import { Code2 } from '@lucide/vue';

defineOptions({
    layout: {
        breadcrumbs: [
            {
                title: 'Skills',
                href: indexSkills(),
            },
        ],
    },
});

interface SkillItem {
    id: number;
    nama: string;
    ikon: string | null;
    gambar: string | null;
    urutan: number;
    status: boolean;
}

const props = defineProps<{
    skills: SkillItem[];
}>();

const isDialogOpen = ref(false);
const isEditing = ref(false);
const currentId = ref<number | null>(null);
const previewUrl = ref<string | null>(null);

const form = useForm({
    nama: '',
    gambar: null as File | null,
    urutan: 0,
    status: true,
    _method: 'POST',
});

const imagePreviewUrl = computed(() => {
    if (previewUrl.value) return previewUrl.value;
    return null;
});

const openAddDialog = () => {
    isEditing.value = false;
    currentId.value = null;
    previewUrl.value = null;
    form.reset();
    form.clearErrors();
    form._method = 'POST';
    isDialogOpen.value = true;
};

const openEditDialog = (item: SkillItem) => {
    isEditing.value = true;
    currentId.value = item.id;
    previewUrl.value = item.gambar ? `/storage/${item.gambar}` : null;
    form.clearErrors();
    form.nama = item.nama;
    form.urutan = item.urutan;
    form.status = item.status;
    form.gambar = null;
    form._method = 'PUT';
    isDialogOpen.value = true;
};

const handleFileChange = (event: Event) => {
    const target = event.target as HTMLInputElement;
    const file = target.files?.[0];
    if (file) {
        form.gambar = file;
        const reader = new FileReader();
        reader.onload = (e) => {
            previewUrl.value = e.target?.result as string;
        };
        reader.readAsDataURL(file);
    }
};

const submitForm = () => {
    if (isEditing.value && currentId.value) {
        form.post(updateSkills.url(currentId.value), {
            forceFormData: true,
            onSuccess: () => {
                isDialogOpen.value = false;
                form.reset();
                previewUrl.value = null;
            },
        });
    } else {
        form.post(storeSkills.url(), {
            forceFormData: true,
            onSuccess: () => {
                isDialogOpen.value = false;
                form.reset();
                previewUrl.value = null;
            },
        });
    }
};

const deleteItem = (id: number) => {
    if (confirm('Apakah Anda yakin ingin menghapus skill ini?')) {
        router.delete(destroySkills.url(id));
    }
};

const toggleStatus = (item: SkillItem) => {
    router.put(updateSkills.url(item.id), {
        nama: item.nama,
        ikon: item.ikon || '',
        urutan: item.urutan,
        status: !item.status,
    });
};
</script>

<template>
    <Head title="Skills" />
    <h1 class="sr-only">Skills</h1>

    <div class="flex flex-col space-y-6 p-6 sm:p-8">
        <div
            class="flex flex-col justify-between gap-4 sm:flex-row sm:items-center"
        >
            <Heading
                variant="small"
                title="Skills"
                description="Kelola daftar keahlian dan teknologi yang akan ditampilkan pada halaman portofolio."
            />
            <Button @click="openAddDialog" class="w-fit shrink-0"
                >Tambah Skill</Button
            >
        </div>

        <!-- List Skills -->
        <div class="space-y-4">
            <div
                v-if="skills.length === 0"
                class="rounded-xl border-2 border-dashed border-neutral-200 p-10 text-center text-muted-foreground sm:p-12 dark:border-neutral-700"
            >
                <div class="flex flex-col items-center gap-2">
                    <Code2
                        class="h-8 w-8 text-neutral-300 dark:text-neutral-600"
                    />
                    <p>Belum ada data skill. Silakan tambahkan data baru.</p>
                </div>
            </div>

            <div
                v-for="item in skills"
                :key="item.id"
                class="flex flex-col justify-between gap-4 rounded-xl border p-5 shadow-sm transition-all hover:bg-neutral-50/50 hover:shadow-md sm:p-6 md:flex-row md:items-center dark:hover:bg-neutral-900/50"
            >
                <div class="flex items-center gap-4">
                    <div
                        class="flex h-10 w-10 shrink-0 items-center justify-center overflow-hidden rounded-lg bg-blue-50 dark:bg-blue-900/20"
                    >
                        <img
                            v-if="item.gambar"
                            :src="`/storage/${item.gambar}`"
                            :alt="item.nama"
                            class="h-full w-full object-contain p-1"
                        />
                        <Code2
                            v-else
                            class="h-5 w-5 text-blue-600 dark:text-blue-400"
                        />
                    </div>
                    <div class="space-y-1">
                        <div class="flex items-center gap-2">
                            <h3 class="text-base font-semibold">
                                {{ item.nama }}
                            </h3>
                            <span
                                @click="toggleStatus(item)"
                                class="inline-flex cursor-pointer items-center gap-1 rounded-full border px-2.5 py-0.5 text-[11px] font-medium transition-all hover:scale-105"
                                :class="
                                    item.status
                                        ? 'border-emerald-200 bg-emerald-50 text-emerald-700 dark:border-emerald-800 dark:bg-emerald-900/20 dark:text-emerald-400'
                                        : 'border-neutral-200 bg-neutral-100 text-neutral-500 dark:border-neutral-700 dark:bg-neutral-800 dark:text-neutral-500'
                                "
                            >
                                <span
                                    class="relative flex h-1.5 w-1.5"
                                    :class="
                                        item.status
                                            ? 'bg-emerald-500'
                                            : 'bg-neutral-400'
                                    "
                                >
                                    <span
                                        v-if="item.status"
                                        class="absolute inline-flex h-full w-full animate-ping rounded-full bg-emerald-400 opacity-75"
                                    ></span>
                                </span>
                                {{ item.status ? 'Aktif' : 'Nonaktif' }}
                            </span>
                        </div>
                        <p class="text-xs text-muted-foreground">
                            Urutan: {{ item.urutan }}
                        </p>
                    </div>
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
            <DialogContent class="sm:max-w-[500px]">
                <form @submit.prevent="submitForm" class="space-y-5">
                    <DialogHeader>
                        <DialogTitle>{{
                            isEditing ? 'Edit Skill' : 'Tambah Skill'
                        }}</DialogTitle>
                        <DialogDescription>
                            Isi form di bawah ini untuk
                            {{ isEditing ? 'memperbarui' : 'menambahkan' }}
                            keahlian Anda.
                        </DialogDescription>
                    </DialogHeader>

                    <div class="space-y-5">
                        <div class="grid gap-2">
                            <Label for="nama">Nama Skill</Label>
                            <Input
                                id="nama"
                                v-model="form.nama"
                                required
                                placeholder="Contoh: HTML, CSS, JavaScript, Laravel"
                            />
                            <InputError :message="form.errors.nama" />
                        </div>

                        <div class="grid gap-2">
                            <Label for="gambar">Logo / Gambar Skill</Label>
                            <div class="flex items-center gap-3">
                                <div
                                    class="flex h-14 w-14 shrink-0 items-center justify-center overflow-hidden rounded-lg border bg-white dark:bg-neutral-900"
                                >
                                    <img
                                        v-if="imagePreviewUrl"
                                        :src="imagePreviewUrl"
                                        alt="Preview"
                                        class="h-full w-full object-contain p-1"
                                    />
                                    <Code2
                                        v-else
                                        class="h-6 w-6 text-neutral-300 dark:text-neutral-600"
                                    />
                                </div>
                                <Input
                                    id="gambar"
                                    type="file"
                                    accept="image/*"
                                    @change="handleFileChange"
                                    class="flex-1"
                                />
                            </div>
                            <p class="text-[11px] text-muted-foreground">
                                Format: JPG, PNG, SVG, WebP. Maksimal 2MB.
                            </p>
                            <InputError :message="form.errors.gambar" />
                        </div>

                        <div class="grid gap-2">
                            <Label for="urutan">Urutan Tampil</Label>
                            <Input
                                id="urutan"
                                type="number"
                                v-model="form.urutan"
                                required
                                min="0"
                                placeholder="0"
                            />
                            <p class="text-[11px] text-muted-foreground">
                                Semakin kecil angka, semakin awal posisi dalam
                                slider.
                            </p>
                            <InputError :message="form.errors.urutan" />
                        </div>

                        <div class="flex items-center gap-3">
                            <label
                                class="relative inline-flex cursor-pointer items-center"
                            >
                                <input
                                    type="checkbox"
                                    v-model="form.status"
                                    class="peer sr-only"
                                />
                                <div
                                    class="h-6 w-11 rounded-full border border-input bg-neutral-200 peer-checked:bg-emerald-500 after:absolute after:top-[2px] after:left-[2px] after:h-5 after:w-5 after:rounded-full after:border after:border-neutral-300 after:bg-white after:transition-all after:content-[''] peer-checked:after:translate-x-full peer-checked:after:border-white dark:border-neutral-600 dark:bg-neutral-700 dark:after:bg-neutral-400"
                                ></div>
                            </label>
                            <Label class="cursor-pointer select-none">{{
                                form.status ? 'Aktif' : 'Nonaktif'
                            }}</Label>
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
