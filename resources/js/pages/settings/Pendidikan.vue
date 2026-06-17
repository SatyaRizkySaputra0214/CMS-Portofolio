<script setup lang="ts">
import { Head, router, useForm } from '@inertiajs/vue3';
import { ref } from 'vue';
import { index as indexPendidikan } from '@/routes/pendidikan';
import { store as storePendidikan, update as updatePendidikan, destroy as destroyPendidikan } from '@/routes/pendidikan';
import Heading from '@/components/Heading.vue';
import InputError from '@/components/InputError.vue';
import { Button } from '@/components/ui/button';
import { Input } from '@/components/ui/input';
import { Label } from '@/components/ui/label';
import { Textarea } from '@/components/ui/textarea';
import { GraduationCap } from '@lucide/vue';
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
                title: 'Riwayat Pendidikan',
                href: indexPendidikan(),
            },
        ],
    },
});

interface PendidikanItem {
    id: number;
    institusi: string;
    gelar_jurusan: string;
    tahun_mulai: number;
    tahun_selesai: number | null;
    deskripsi: string | null;
}

const props = defineProps<{
    pendidikan: PendidikanItem[];
}>();

const isDialogOpen = ref(false);
const isEditing = ref(false);
const currentId = ref<number | null>(null);

const form = useForm({
    institusi: '',
    gelar_jurusan: '',
    tahun_mulai: new Date().getFullYear(),
    tahun_selesai: null as number | null,
    deskripsi: '',
});

const openAddDialog = () => {
    isEditing.value = false;
    currentId.value = null;
    form.reset();
    form.clearErrors();
    isDialogOpen.value = true;
};

const openEditDialog = (item: PendidikanItem) => {
    isEditing.value = true;
    currentId.value = item.id;
    form.clearErrors();
    form.institusi = item.institusi;
    form.gelar_jurusan = item.gelar_jurusan;
    form.tahun_mulai = item.tahun_mulai;
    form.tahun_selesai = item.tahun_selesai;
    form.deskripsi = item.deskripsi || '';
    isDialogOpen.value = true;
};

const submitForm = () => {
    if (isEditing.value && currentId.value) {
        form.put(updatePendidikan.url(currentId.value), {
            onSuccess: () => {
                isDialogOpen.value = false;
                form.reset();
            },
        });
    } else {
        form.post(storePendidikan.url(), {
            onSuccess: () => {
                isDialogOpen.value = false;
                form.reset();
            },
        });
    }
};

const deleteItem = (id: number) => {
    if (confirm('Apakah Anda yakin ingin menghapus data pendidikan ini?')) {
        router.delete(destroyPendidikan.url(id));
    }
};
</script>

<template>
    <Head title="Riwayat Pendidikan" />
    <h1 class="sr-only">Riwayat Pendidikan</h1>

    <div class="flex flex-col space-y-6 p-6 sm:p-8">
        <div class="flex flex-col justify-between gap-4 sm:flex-row sm:items-center">
            <Heading
                variant="small"
                title="Riwayat Pendidikan"
                description="Kelola daftar instansi pendidikan, jurusan, dan gelar Anda."
            />
            <Button @click="openAddDialog" class="w-fit shrink-0">Tambah Pendidikan</Button>
        </div>

        <!-- List Pendidikan -->
        <div class="space-y-4">
            <div v-if="pendidikan.length === 0" class="rounded-xl border-2 border-dashed border-neutral-200 dark:border-neutral-700 p-10 sm:p-12 text-center text-muted-foreground">
                <div class="flex flex-col items-center gap-2">
                    <GraduationCap class="h-8 w-8 text-neutral-300 dark:text-neutral-600" />
                    <p>Belum ada data pendidikan. Silakan tambahkan data baru.</p>
                </div>
            </div>

            <div
                v-for="item in pendidikan"
                :key="item.id"
                class="flex flex-col justify-between gap-4 rounded-xl border p-5 sm:p-6 shadow-sm transition-all hover:bg-neutral-50/50 dark:hover:bg-neutral-900/50 hover:shadow-md md:flex-row md:items-start"
            >
                <div class="space-y-2.5">
                    <div class="flex flex-wrap items-center gap-2">
                        <h3 class="text-base font-semibold">{{ item.institusi }}</h3>
                        <span class="rounded-md bg-slate-100 px-2.5 py-1 text-xs font-medium dark:bg-neutral-800 text-muted-foreground">
                            {{ item.tahun_mulai }} - {{ item.tahun_selesai || 'Sekarang' }}
                        </span>
                    </div>
                    <p class="text-sm font-medium text-muted-foreground">{{ item.gelar_jurusan }}</p>
                    <p v-if="item.deskripsi" class="text-sm text-neutral-600 dark:text-neutral-300 whitespace-pre-wrap leading-relaxed">{{ item.deskripsi }}</p>
                </div>
                <div class="flex items-center gap-2 shrink-0">
                    <Button variant="outline" size="sm" @click="openEditDialog(item)">Edit</Button>
                    <Button variant="destructive" size="sm" @click="deleteItem(item.id)">Hapus</Button>
                </div>
            </div>
        </div>

        <!-- Dialog Modal Form -->
        <Dialog :open="isDialogOpen" @update:open="isDialogOpen = $event">
            <DialogContent class="sm:max-w-[500px]">
                <form @submit.prevent="submitForm" class="space-y-5">
                    <DialogHeader>
                        <DialogTitle>{{ isEditing ? 'Edit Pendidikan' : 'Tambah Pendidikan' }}</DialogTitle>
                        <DialogDescription>
                            Isi form di bawah ini untuk {{ isEditing ? 'memperbarui' : 'menambahkan' }} riwayat pendidikan Anda.
                        </DialogDescription>
                    </DialogHeader>

                    <div class="space-y-5">
                        <div class="grid gap-2">
                            <Label for="institusi">Institusi / Universitas</Label>
                            <Input
                                id="institusi"
                                v-model="form.institusi"
                                required
                                placeholder="Contoh: Universitas Indonesia"
                            />
                            <InputError :message="form.errors.institusi" />
                        </div>

                        <div class="grid gap-2">
                            <Label for="gelar_jurusan">Gelar & Jurusan</Label>
                            <Input
                                id="gelar_jurusan"
                                v-model="form.gelar_jurusan"
                                required
                                placeholder="Contoh: S1 Teknik Informatika"
                            />
                            <InputError :message="form.errors.gelar_jurusan" />
                        </div>

                        <div class="grid grid-cols-2 gap-4">
                            <div class="grid gap-2">
                                <Label for="tahun_mulai">Tahun Mulai</Label>
                                <Input
                                    id="tahun_mulai"
                                    type="number"
                                    v-model="form.tahun_mulai"
                                    required
                                />
                                <InputError :message="form.errors.tahun_mulai" />
                            </div>
                            <div class="grid gap-2">
                                <Label for="tahun_selesai">Tahun Selesai <span class="text-muted-foreground font-normal">(opsional)</span></Label>
                                <Input
                                    id="tahun_selesai"
                                    type="number"
                                    v-model="form.tahun_selesai"
                                    placeholder="Kosongkan jika masih studi"
                                />
                                <InputError :message="form.errors.tahun_selesai" />
                            </div>
                        </div>

                        <div class="grid gap-2">
                            <Label for="deskripsi">Deskripsi Kegiatan / Prestasi</Label>
                            <Textarea
                                id="deskripsi"
                                v-model="form.deskripsi"
                                placeholder="Tuliskan IPK, organisasi, atau prestasi di sini..."
                                class="min-h-[100px]"
                            />
                            <InputError :message="form.errors.deskripsi" />
                        </div>
                    </div>

                    <DialogFooter class="pt-2">
                        <Button type="button" variant="outline" @click="isDialogOpen = false">Batal</Button>
                        <Button type="submit" :disabled="form.processing">Simpan</Button>
                    </DialogFooter>
                </form>
            </DialogContent>
        </Dialog>
    </div>
</template>
