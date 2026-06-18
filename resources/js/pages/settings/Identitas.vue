<script setup lang="ts">
import { Form, Head } from '@inertiajs/vue3';
import { edit as editIdentitas } from '@/routes/identitas';
import IdentitasController from '@/actions/App/Http/Controllers/IdentitasController';
import Heading from '@/components/Heading.vue';
import InputError from '@/components/InputError.vue';
import { Button } from '@/components/ui/button';
import { Input } from '@/components/ui/input';
import { Label } from '@/components/ui/label';
import { Textarea } from '@/components/ui/textarea';

defineOptions({
    layout: {
        breadcrumbs: [
            {
                title: 'Identitas Portofolio',
                href: editIdentitas(),
            },
        ],
    },
});

const props = defineProps<{
    identitas?: {
        nama_lengkap: string;
        profesi: string;
        tentang_saya: string;
        foto_profil: string | null;
        cv_file: string | null;
    } | null;
}>();
</script>

<template>
    <Head title="Identitas Portofolio" />
    <h1 class="sr-only">Identitas Portofolio</h1>

    <div class="flex flex-col space-y-6 p-6 sm:p-8">
        <Heading
            variant="small"
            title="Identitas Portofolio"
            description="Atur nama, profesi, bio, foto profil, dan file CV yang akan ditampilkan di halaman publik."
        />

        <Form
            v-bind="IdentitasController.update.form()"
            class="space-y-6"
            v-slot="{ errors, processing }"
        >
            <div class="grid gap-2">
                <Label for="nama_lengkap">Nama Lengkap</Label>
                <Input
                    id="nama_lengkap"
                    class="mt-1 block w-full"
                    name="nama_lengkap"
                    :default-value="identitas?.nama_lengkap ?? ''"
                    required
                    placeholder="Nama Lengkap Anda"
                />
                <InputError class="mt-2" :message="errors.nama_lengkap" />
            </div>

            <div class="grid gap-2">
                <Label for="profesi">Profesi Utama</Label>
                <Input
                    id="profesi"
                    class="mt-1 block w-full"
                    name="profesi"
                    :default-value="identitas?.profesi ?? ''"
                    required
                    placeholder="Contoh: Software Engineer, UI/UX Designer"
                />
                <InputError class="mt-2" :message="errors.profesi" />
            </div>

            <div class="grid gap-2">
                <Label for="tentang_saya">Tentang Saya / Bio</Label>
                <Textarea
                    id="tentang_saya"
                    class="mt-1 block min-h-[100px] w-full"
                    name="tentang_saya"
                    :default-value="identitas?.tentang_saya ?? ''"
                    placeholder="Tuliskan deskripsi singkat mengenai diri Anda..."
                />
                <InputError class="mt-2" :message="errors.tentang_saya" />
            </div>

            <div class="grid gap-2">
                <Label for="foto_profil"
                    >Foto Profil
                    <span class="font-normal text-muted-foreground"
                        >(Max 2MB)</span
                    ></Label
                >
                <Input
                    id="foto_profil"
                    type="file"
                    class="mt-1 block w-full"
                    name="foto_profil"
                />
                <div
                    v-if="identitas?.foto_profil"
                    class="mt-3 flex items-center gap-4 rounded-lg border bg-muted/50 p-3"
                >
                    <img
                        :src="`/storage/${identitas.foto_profil}`"
                        alt="Foto Profil"
                        class="h-16 w-16 rounded-full border-2 border-border object-cover"
                    />
                    <div class="space-y-0.5">
                        <p class="text-sm font-medium">Foto profil aktif</p>
                        <p class="text-xs text-muted-foreground">
                            Upload foto baru untuk menggantinya
                        </p>
                    </div>
                </div>
                <InputError class="mt-2" :message="errors.foto_profil" />
            </div>

            <div class="grid gap-2">
                <Label for="cv_file"
                    >File CV
                    <span class="font-normal text-muted-foreground"
                        >(PDF / DOC / DOCX, Max 5MB)</span
                    ></Label
                >
                <Input
                    id="cv_file"
                    type="file"
                    class="mt-1 block w-full"
                    name="cv_file"
                />
                <div v-if="identitas?.cv_file" class="mt-2">
                    <a
                        :href="`/storage/${identitas.cv_file}`"
                        target="_blank"
                        class="inline-flex items-center gap-1.5 text-sm font-medium text-blue-600 transition-colors hover:text-blue-500"
                    >
                        <span>Lihat CV Saat Ini</span>
                        <svg
                            class="h-3.5 w-3.5"
                            fill="none"
                            stroke="currentColor"
                            viewBox="0 0 24 24"
                        >
                            <path
                                stroke-linecap="round"
                                stroke-linejoin="round"
                                stroke-width="2"
                                d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"
                            />
                        </svg>
                    </a>
                </div>
                <InputError class="mt-2" :message="errors.cv_file" />
            </div>

            <div class="flex items-center gap-4 pt-2">
                <Button :disabled="processing">Simpan Perubahan</Button>
            </div>
        </Form>
    </div>
</template>
