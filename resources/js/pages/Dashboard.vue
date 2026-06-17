<script setup lang="ts">
import { Head, Link, usePage } from '@inertiajs/vue3';
import { computed } from 'vue';
import { dashboard } from '@/routes';
import { edit as editIdentitas } from '@/routes/identitas';
import { index as indexPendidikan } from '@/routes/pendidikan';
import { index as indexPengalaman } from '@/routes/pengalaman';
import { index as indexPortofolio } from '@/routes/portofolio';
import { index as indexKontak } from '@/routes/kontak';
import Heading from '@/components/Heading.vue';
import { Card, CardContent, CardDescription, CardHeader, CardTitle } from '@/components/ui/card';
import { FolderGit2, GraduationCap, Briefcase, Share2, Sparkles } from '@lucide/vue';

defineOptions({
    layout: {
        breadcrumbs: [
            {
                title: 'Dashboard',
                href: dashboard(),
            },
        ],
    },
});

interface Stats {
    pendidikan_count: number;
    pengalaman_count: number;
    portofolio_count: number;
    kontak_count: number;
}

interface Identitas {
    nama_lengkap: string;
    profesi: string;
    tentang_saya: string;
    foto_profil: string | null;
    cv_file: string | null;
}

defineProps<{
    stats: Stats;
    identitas?: Identitas | null;
}>();

const page = usePage();
const user = computed(() => page.props.auth.user);
</script>

<template>
    <Head title="Dashboard Admin" />

    <div class="flex flex-col gap-6 p-6 sm:p-8">
        <!-- Welcome banner -->
        <div class="rounded-xl border bg-card p-6 sm:p-8 shadow-sm relative overflow-hidden bg-gradient-to-r from-slate-50 to-neutral-50/50 dark:from-neutral-900/40 dark:to-neutral-900/10">
            <div class="flex flex-col gap-3 relative z-10">
                <div class="flex items-center gap-2 text-primary">
                    <Sparkles class="h-5 w-5 text-blue-500" />
                    <span class="text-xs font-semibold tracking-widest uppercase text-blue-500">CMS Panel</span>
                </div>
                <h1 class="text-2xl sm:text-3xl font-bold tracking-tight">
                    Selamat Datang, {{ identitas?.nama_lengkap || user?.username }}!
                </h1>
                <p class="text-muted-foreground text-sm max-w-2xl leading-relaxed">
                    Kelola website portofolio dinamis Anda di sini. Semua perubahan yang Anda simpan akan langsung tampil secara real-time pada halaman publik.
                </p>
                <div class="mt-2 flex flex-wrap gap-3">
                    <Link :href="editIdentitas()" class="inline-flex items-center justify-center rounded-lg bg-primary px-5 py-2.5 text-sm font-medium text-primary-foreground shadow-xs hover:bg-primary/90 hover:shadow-sm transition-all active:scale-[0.97]">
                        Atur Identitas
                    </Link>
                    <a href="/" target="_blank" class="inline-flex items-center justify-center rounded-lg border bg-background px-5 py-2.5 text-sm font-medium hover:bg-muted transition-all active:scale-[0.97]">
                        Lihat Website Publik
                    </a>
                </div>
            </div>
        </div>

        <Heading
            variant="small"
            title="Ringkasan Portofolio"
            description="Overview data konten website portofolio Anda saat ini."
        />

        <!-- Stats Grid -->
        <div class="grid gap-4 sm:gap-5 sm:grid-cols-2 lg:grid-cols-4">
            <!-- Portofolio Card -->
            <Card class="hover:border-blue-500/50 hover:shadow-md transition-all duration-300">
                <CardHeader class="flex flex-row items-center justify-between space-y-0 pb-2">
                    <CardTitle class="text-sm font-medium">Proyek Portofolio</CardTitle>
                    <div class="h-8 w-8 rounded-lg bg-blue-50 dark:bg-blue-950/30 flex items-center justify-center">
                        <FolderGit2 class="h-4 w-4 text-blue-500" />
                    </div>
                </CardHeader>
                <CardContent>
                    <div class="text-3xl font-bold tracking-tight">{{ stats.portofolio_count }}</div>
                    <p class="text-xs text-muted-foreground mt-1">Proyek/karya aktif</p>
                    <Link :href="indexPortofolio()" class="mt-4 inline-flex items-center gap-1 text-xs font-semibold text-blue-600 hover:text-blue-500 transition-colors">
                        Kelola Proyek
                        <span aria-hidden="true">&rarr;</span>
                    </Link>
                </CardContent>
            </Card>

            <!-- Pengalaman Card -->
            <Card class="hover:border-blue-500/50 hover:shadow-md transition-all duration-300">
                <CardHeader class="flex flex-row items-center justify-between space-y-0 pb-2">
                    <CardTitle class="text-sm font-medium">Riwayat Pengalaman</CardTitle>
                    <div class="h-8 w-8 rounded-lg bg-emerald-50 dark:bg-emerald-950/30 flex items-center justify-center">
                        <Briefcase class="h-4 w-4 text-emerald-500" />
                    </div>
                </CardHeader>
                <CardContent>
                    <div class="text-3xl font-bold tracking-tight">{{ stats.pengalaman_count }}</div>
                    <p class="text-xs text-muted-foreground mt-1">Organisasi, Magang, & Kerja</p>
                    <Link :href="indexPengalaman()" class="mt-4 inline-flex items-center gap-1 text-xs font-semibold text-blue-600 hover:text-blue-500 transition-colors">
                        Kelola Pengalaman
                        <span aria-hidden="true">&rarr;</span>
                    </Link>
                </CardContent>
            </Card>

            <!-- Pendidikan Card -->
            <Card class="hover:border-blue-500/50 hover:shadow-md transition-all duration-300">
                <CardHeader class="flex flex-row items-center justify-between space-y-0 pb-2">
                    <CardTitle class="text-sm font-medium">Riwayat Pendidikan</CardTitle>
                    <div class="h-8 w-8 rounded-lg bg-purple-50 dark:bg-purple-950/30 flex items-center justify-center">
                        <GraduationCap class="h-4 w-4 text-purple-500" />
                    </div>
                </CardHeader>
                <CardContent>
                    <div class="text-3xl font-bold tracking-tight">{{ stats.pendidikan_count }}</div>
                    <p class="text-xs text-muted-foreground mt-1">Institusi terdaftar</p>
                    <Link :href="indexPendidikan()" class="mt-4 inline-flex items-center gap-1 text-xs font-semibold text-blue-600 hover:text-blue-500 transition-colors">
                        Kelola Pendidikan
                        <span aria-hidden="true">&rarr;</span>
                    </Link>
                </CardContent>
            </Card>

            <!-- Kontak Card -->
            <Card class="hover:border-blue-500/50 hover:shadow-md transition-all duration-300">
                <CardHeader class="flex flex-row items-center justify-between space-y-0 pb-2">
                    <CardTitle class="text-sm font-medium">Tautan Kontak</CardTitle>
                    <div class="h-8 w-8 rounded-lg bg-orange-50 dark:bg-orange-950/30 flex items-center justify-center">
                        <Share2 class="h-4 w-4 text-orange-500" />
                    </div>
                </CardHeader>
                <CardContent>
                    <div class="text-3xl font-bold tracking-tight">{{ stats.kontak_count }}</div>
                    <p class="text-xs text-muted-foreground mt-1">Media sosial & link aktif</p>
                    <Link :href="indexKontak()" class="mt-4 inline-flex items-center gap-1 text-xs font-semibold text-blue-600 hover:text-blue-500 transition-colors">
                        Kelola Kontak
                        <span aria-hidden="true">&rarr;</span>
                    </Link>
                </CardContent>
            </Card>
        </div>
    </div>
</template>
