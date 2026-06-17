<script setup lang="ts">
import { Head, router, useForm } from '@inertiajs/vue3';
import { ref } from 'vue';
import { index as indexPengalaman } from '@/routes/pengalaman';
import { store as storePengalaman, update as updatePengalaman, destroy as destroyPengalaman } from '@/routes/pengalaman';
import Heading from '@/components/Heading.vue';
import InputError from '@/components/InputError.vue';
import { Button } from '@/components/ui/button';
import { Input } from '@/components/ui/input';
import { Label } from '@/components/ui/label';
import { Textarea } from '@/components/ui/textarea';
import {
    Dialog,
    DialogContent,
    DialogDescription,
    DialogFooter,
    DialogHeader,
    DialogTitle,
} from '@/components/ui/dialog';
import { Briefcase } from '@lucide/vue';

defineOptions({
    layout: {
        breadcrumbs: [
            {
                title: 'Riwayat Pengalaman',
                href: indexPengalaman(),
            },
        ],
    },
});

interface PengalamanItem {
    id: number;
    kategori: 'Organisasi' | 'Magang' | 'Kerja';
    posisi: string;
    nama_instansi: string;
    tanggal_mulai: string;
    tanggal_selesai: string | null;
    deskripsi: string | null;
}

const props = defineProps<{
    pengalaman: PengalamanItem[];
}>();

const isDialogOpen = ref(false);
const isEditing = ref(false);
const currentId = ref<number | null>(null);

const form = useForm({
    kategori: 'Kerja' as 'Organisasi' | 'Magang' | 'Kerja',
    posisi: '',
    nama_instansi: '',
    tanggal_mulai: '',
    tanggal_selesai: null as string | null,
    deskripsi: '',
});

const openAddDialog = () => {
    isEditing.value = false;
    currentId.value = null;
    form.reset();
    form.clearErrors();
    isDialogOpen.value = true;
};

const openEditDialog = (item: PengalamanItem) => {
    isEditing.value = true;
    currentId.value = item.id;
    form.clearErrors();
    form.kategori = item.kategori;
    form.posisi = item.posisi;
    form.nama_instansi = item.nama_instansi;
    form.tanggal_mulai = item.tanggal_mulai;
    form.tanggal_selesai = item.tanggal_selesai;
    form.deskripsi = item.deskripsi || '';
    isDialogOpen.value = true;
};

const submitForm = () => {
    // If tanggal_selesai is empty, set it to null
    if (!form.tanggal_selesai) {
        form.tanggal_selesai = null;
    }
    
    if (isEditing.value && currentId.value) {
        form.put(updatePengalaman.url(currentId.value), {
            onSuccess: () => {
                isDialogOpen.value = false;
                form.reset();
            },
        });
    } else {
        form.post(storePengalaman.url(), {
            onSuccess: () => {
                isDialogOpen.value = false;
                form.reset();
            },
        });
    }
};

const deleteItem = (id: number) => {
    if (confirm('Apakah Anda yakin ingin menghapus data pengalaman ini?')) {
        router.delete(destroyPengalaman.url(id));
    }
};

const formatDate = (dateStr: string | null) => {
    if (!dateStr) return 'Present';
    const date = new Date(dateStr);
    return date.toLocaleDateString('id-ID', { year: 'numeric', month: 'long' });
};

const getBadgeColor = (category: string) => {
    switch (category) {
        case 'Kerja':
            return 'bg-blue-50 text-blue-700 border-blue-200 dark:bg-blue-900/20 dark:text-blue-400 dark:border-blue-800';
        case 'Magang':
            return 'bg-emerald-50 text-emerald-700 border-emerald-200 dark:bg-emerald-900/20 dark:text-emerald-400 dark:border-emerald-800';
        default:
            return 'bg-amber-50 text-amber-700 border-amber-200 dark:bg-amber-900/20 dark:text-amber-400 dark:border-amber-800';
    }
};
</script>

<template>
    <Head title="Riwayat Pengalaman" />
    <h1 class="sr-only">Riwayat Pengalaman</h1>

    <div class="flex flex-col space-y-6 p-6 sm:p-8">
        <div class="flex flex-col justify-between gap-4 sm:flex-row sm:items-center">
            <Heading
                variant="small"
                title="Riwayat Pengalaman"
                description="Kelola daftar organisasi, magang, dan riwayat pekerjaan profesional Anda."
            />
            <Button @click="openAddDialog" class="w-fit shrink-0">Tambah Pengalaman</Button>
        </div>

        <!-- List Pengalaman -->
        <div class="space-y-4">
            <div v-if="pengalaman.length === 0" class="rounded-xl border-2 border-dashed border-neutral-200 dark:border-neutral-700 p-10 sm:p-12 text-center text-muted-foreground">
                <div class="flex flex-col items-center gap-2">
                    <Briefcase class="h-8 w-8 text-neutral-300 dark:text-neutral-600" />
                    <p>Belum ada data pengalaman. Silakan tambahkan data baru.</p>
                </div>
            </div>

            <div
                v-for="item in pengalaman"
                :key="item.id"
                class="flex flex-col justify-between gap-4 rounded-xl border p-5 sm:p-6 shadow-sm transition-all hover:bg-neutral-50/50 dark:hover:bg-neutral-900/50 hover:shadow-md md:flex-row md:items-start"
            >
                <div class="space-y-2.5">
                    <div class="flex flex-wrap items-center gap-2">
                        <h3 class="text-base font-semibold">{{ item.posisi }}</h3>
                        <span :class="['rounded-md px-2.5 py-1 text-xs font-medium border', getBadgeColor(item.kategori)]">
                            {{ item.kategori }}
                        </span>
                        <span class="text-xs text-muted-foreground">
                            {{ formatDate(item.tanggal_mulai) }} - {{ formatDate(item.tanggal_selesai) }}
                        </span>
                    </div>
                    <p class="text-sm font-medium text-muted-foreground">{{ item.nama_instansi }}</p>
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
                        <DialogTitle>{{ isEditing ? 'Edit Pengalaman' : 'Tambah Pengalaman' }}</DialogTitle>
                        <DialogDescription>
                            Isi form di bawah ini untuk {{ isEditing ? 'memperbarui' : 'menambahkan' }} riwayat pengalaman Anda.
                        </DialogDescription>
                    </DialogHeader>

                    <div class="space-y-5">
                        <div class="grid gap-2">
                            <Label for="kategori">Kategori Pengalaman</Label>
                            <select
                                id="kategori"
                                v-model="form.kategori"
                                required
                                class="flex h-9 w-full rounded-md border border-input bg-transparent px-3 py-1 text-sm shadow-xs transition-colors outline-none focus-visible:ring-1 focus-visible:ring-ring focus-visible:border-ring disabled:cursor-not-allowed disabled:opacity-50 dark:bg-input/30"
                            >
                                <option value="Kerja">Kerja Profesional</option>
                                <option value="Magang">Magang / Internship</option>
                                <option value="Organisasi">Organisasi</option>
                            </select>
                            <InputError :message="form.errors.kategori" />
                        </div>

                        <div class="grid gap-2">
                            <Label for="posisi">Posisi / Jabatan</Label>
                            <Input
                                id="posisi"
                                v-model="form.posisi"
                                required
                                placeholder="Contoh: Frontend Developer, Project Manager"
                            />
                            <InputError :message="form.errors.posisi" />
                        </div>

                        <div class="grid gap-2">
                            <Label for="nama_instansi">Nama Perusahaan / Organisasi</Label>
                            <Input
                                id="nama_instansi"
                                v-model="form.nama_instansi"
                                required
                                placeholder="Contoh: PT. Digital Nusantara"
                            />
                            <InputError :message="form.errors.nama_instansi" />
                        </div>

                        <div class="grid grid-cols-2 gap-4">
                            <div class="grid gap-2">
                                <Label for="tanggal_mulai">Tanggal Mulai</Label>
                                <Input
                                    id="tanggal_mulai"
                                    type="date"
                                    v-model="form.tanggal_mulai"
                                    required
                                />
                                <InputError :message="form.errors.tanggal_mulai" />
                            </div>
                            <div class="grid gap-2">
                                <Label for="tanggal_selesai">Tanggal Selesai <span class="text-muted-foreground font-normal">(opsional)</span></Label>
                                <Input
                                    id="tanggal_selesai"
                                    type="date"
                                    v-model="form.tanggal_selesai"
                                    placeholder="Kosongkan jika saat ini masih aktif"
                                />
                                <InputError :message="form.errors.tanggal_selesai" />
                            </div>
                        </div>

                        <div class="grid gap-2">
                            <Label for="deskripsi">Deskripsi Pekerjaan / Kegiatan</Label>
                            <Textarea
                                id="deskripsi"
                                v-model="form.deskripsi"
                                placeholder="Tuliskan tugas, tanggung jawab, dan pencapaian Anda di sini..."
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
