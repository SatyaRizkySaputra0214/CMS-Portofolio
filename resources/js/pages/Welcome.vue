<script setup lang="ts">
import { Head } from '@inertiajs/vue3';
import { ref, onMounted, onUnmounted } from 'vue';

import {
    Link as LinkIcon,
    FileDown,
    GraduationCap,
    Briefcase,
    FolderGit2,
    ArrowUpRight,
    Calendar,
    ArrowRight,
    Sun,
    Moon,
    Quote,
    Target,
    Star,
    Code2,
    Zap,
} from '@lucide/vue';
import { useAppearance } from '@/composables/useAppearance';
import {
    Dialog,
    DialogContent,
    DialogDescription,
    DialogFooter,
    DialogHeader,
    DialogTitle,
} from '@/components/ui/dialog';
import { Button } from '@/components/ui/button';

interface Identitas {
    nama_lengkap: string;
    profesi: string;
    tentang_saya: string | null;
    foto_profil: string | null;
    cv_file: string | null;
}

interface PendidikanItem {
    id: number;
    institusi: string;
    gelar_jurusan: string;
    tahun_mulai: number;
    tahun_selesai: number | null;
    deskripsi: string | null;
}

interface PengalamanItem {
    id: number;
    kategori: 'Organisasi' | 'Magang' | 'Kerja';
    posisi: string;
    nama_instansi: string;
    tanggal_mulai: string;
    tanggal_selesai: string | null;
    deskripsi: string | null;
}

interface PortofolioItem {
    id: number;
    judul_proyek: string;
    thumbnail: string | null;
    deskripsi_singkat: string;
    deskripsi_lengkap: string | null;
    link_eksternal: string | null;
    tools: string[] | null;
    dibuat_pada: string;
}

interface KontakItem {
    id: number;
    platform: string;
    url: string;
    ikon: string | null;
}

interface SkillItem {
    id: number;
    nama: string;
    ikon: string | null;
    gambar: string | null;
    urutan: number;
    status: boolean;
}

const props = defineProps<{
    identitas: Identitas;
    pendidikan: PendidikanItem[];
    pengalaman: PengalamanItem[];
    portofolio: PortofolioItem[];
    kontak: KontakItem[];
    skills: SkillItem[];
}>();

const selectedProject = ref<PortofolioItem | null>(null);
const isDetailOpen = ref(false);
const isSkillsPaused = ref(false);

const openDetail = (project: PortofolioItem) => {
    selectedProject.value = project;
    isDetailOpen.value = true;
};

const handleDetailClose = (open: boolean) => {
    isDetailOpen.value = open;
    if (!open) {
        setTimeout(() => {
            selectedProject.value = null;
        }, 250);
    }
};

const formatDate = (dateStr: string | null) => {
    if (!dateStr) return 'Sekarang';
    const date = new Date(dateStr);
    return date.toLocaleDateString('id-ID', {
        year: 'numeric',
        month: 'short',
    });
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

const getTechBadgeColor = (index: number) => {
    const colors = [
        'bg-blue-100 text-blue-700 dark:bg-blue-900/30 dark:text-blue-300',
        'bg-purple-100 text-purple-700 dark:bg-purple-900/30 dark:text-purple-300',
        'bg-emerald-100 text-emerald-700 dark:bg-emerald-900/30 dark:text-emerald-300',
        'bg-amber-100 text-amber-700 dark:bg-amber-900/30 dark:text-amber-300',
        'bg-rose-100 text-rose-700 dark:bg-rose-900/30 dark:text-rose-300',
        'bg-cyan-100 text-cyan-700 dark:bg-cyan-900/30 dark:text-cyan-300',
    ];
    return colors[index % colors.length];
};

const { resolvedAppearance, updateAppearance } = useAppearance();

const toggleTheme = () => {
    updateAppearance(resolvedAppearance.value === 'dark' ? 'light' : 'dark');
};

// Scroll reveal observer
const observerRef = ref<IntersectionObserver | null>(null);

onMounted(() => {
    observerRef.value = new IntersectionObserver(
        (entries) => {
            entries.forEach((entry) => {
                if (entry.isIntersecting) {
                    entry.target.classList.add('revealed');
                    observerRef.value?.unobserve(entry.target);
                }
            });
        },
        { threshold: 0.1, rootMargin: '0px 0px -60px 0px' },
    );

    document.querySelectorAll('.reveal, .section-reveal').forEach((el) => {
        observerRef.value?.observe(el);
    });
});

onUnmounted(() => {
    observerRef.value?.disconnect();
});
</script>

<template>
    <Head title="Portofolio Dinamis" />

    <div
        class="min-h-screen bg-[#F8FAFC] text-[#334155] transition-colors duration-300 selection:bg-blue-500/20 selection:text-blue-700 dark:bg-[#09090b] dark:text-[#a1a1aa] dark:selection:text-blue-300"
    >
        <!-- ==================== HEADER ==================== -->
        <header
            class="fixed top-0 z-50 w-full border-b border-transparent bg-white/70 backdrop-blur-xl transition-all duration-300 supports-backdrop-blur:bg-white/80 dark:border-[#27272a]/50 dark:bg-[#09090b]/70"
        >
            <div
                class="mx-auto flex h-16 max-w-6xl items-center justify-between px-4 sm:px-6 lg:px-8"
            >
                <div class="flex items-center gap-2 sm:gap-4">
                    <nav
                        class="hidden items-center gap-8 text-sm font-medium md:flex"
                    >
                        <a
                            href="#about"
                            class="relative text-[#334155] transition-colors after:absolute after:-bottom-1 after:left-0 after:h-0.5 after:w-0 after:bg-blue-600 after:transition-all hover:text-blue-600 hover:after:w-full dark:text-[#a1a1aa] dark:hover:text-blue-400"
                            >Tentang</a
                        >
                        <a
                            href="#timeline"
                            class="relative text-[#334155] transition-colors after:absolute after:-bottom-1 after:left-0 after:h-0.5 after:w-0 after:bg-blue-600 after:transition-all hover:text-blue-600 hover:after:w-full dark:text-[#a1a1aa] dark:hover:text-blue-400"
                            >Riwayat</a
                        >
                        <a
                            href="#projects"
                            class="relative text-[#334155] transition-colors after:absolute after:-bottom-1 after:left-0 after:h-0.5 after:w-0 after:bg-blue-600 after:transition-all hover:text-blue-600 hover:after:w-full dark:text-[#a1a1aa] dark:hover:text-blue-400"
                            >Proyek</a
                        >
                        <a
                            href="#contact"
                            class="relative text-[#334155] transition-colors after:absolute after:-bottom-1 after:left-0 after:h-0.5 after:w-0 after:bg-blue-600 after:transition-all hover:text-blue-600 hover:after:w-full dark:text-[#a1a1aa] dark:hover:text-blue-400"
                            >Kontak</a
                        >
                    </nav>

                    <button
                        @click="toggleTheme"
                        class="relative flex h-9 w-9 items-center justify-center rounded-xl bg-neutral-100 text-[#334155] transition-all hover:bg-neutral-200 focus-visible:ring-2 focus-visible:ring-blue-500 focus-visible:ring-offset-2 focus-visible:outline-none dark:bg-neutral-800 dark:text-[#a1a1aa] dark:hover:bg-neutral-700"
                        aria-label="Toggle theme"
                    >
                        <Sun
                            v-if="resolvedAppearance === 'dark'"
                            class="h-4 w-4 text-amber-400"
                        />
                        <Moon
                            v-else
                            class="h-4 w-4 text-slate-600 dark:text-neutral-400"
                        />
                    </button>
                </div>
            </div>
        </header>

        <!-- ==================== HERO SECTION ==================== -->
        <section
            id="hero"
            class="relative flex min-h-screen items-center overflow-hidden bg-[#0F172A] pt-16"
        >
            <!-- Dark grid patterns and texture overlays -->
            <div class="bg-grid-tech absolute inset-0 opacity-100"></div>
            <div class="bg-grid-dots absolute inset-0 opacity-60"></div>
            <div
                class="bg-noise pointer-events-none absolute inset-0 opacity-100"
            ></div>

            <!-- Dashboard subtle glowing radial overlays -->
            <div
                class="pointer-events-none absolute inset-0"
                style="
                    background-image:
                        radial-gradient(
                            circle at 80% 20%,
                            rgba(37, 99, 235, 0.16),
                            transparent 45%
                        ),
                        radial-gradient(
                            circle at 20% 80%,
                            rgba(14, 165, 233, 0.08),
                            transparent 45%
                        );
                "
            ></div>

            <!-- Technical decorative elements (subtle lines and metrics) -->
            <div class="pointer-events-none absolute inset-0 overflow-hidden">
                <!-- Glowing tech accent lines -->
                <div
                    class="absolute top-[20%] left-0 h-[1px] w-full bg-gradient-to-r from-transparent via-blue-500/10 to-transparent"
                ></div>
                <div
                    class="absolute bottom-[25%] left-0 h-[1px] w-full bg-gradient-to-r from-transparent via-sky-500/10 to-transparent"
                ></div>
                <div
                    class="absolute top-1/3 left-[5%] h-32 w-[1px] bg-gradient-to-b from-blue-500/0 via-blue-500/15 to-blue-500/0"
                ></div>
                <div
                    class="absolute right-[5%] bottom-1/3 h-32 w-[1px] bg-gradient-to-b from-sky-500/0 via-sky-500/15 to-sky-500/0"
                ></div>

                <!-- Small dashboard code labels -->
                <div
                    class="absolute top-24 left-8 hidden font-mono text-[9px] tracking-widest text-slate-600 md:block"
                >
                    SYS_STATUS // ACTIVE
                </div>
                <div
                    class="absolute bottom-12 left-8 hidden font-mono text-[9px] tracking-widest text-slate-600 md:block"
                >
                    LOC // 0x7F - SERVER_UP
                </div>
            </div>

            <div
                class="relative z-10 mx-auto w-full max-w-6xl px-4 py-16 sm:py-20 lg:py-24"
            >
                <div
                    class="grid grid-cols-1 items-center gap-12 lg:grid-cols-12 lg:gap-16"
                >
                    <!-- Hero Text (55% / 7 cols) -->
                    <div
                        class="section-reveal space-y-7 text-center lg:col-span-7 lg:text-left"
                    >
                        <!-- Status availability badge -->
                        <div
                            class="inline-flex items-center gap-2.5 rounded-full border border-slate-800 bg-slate-900/90 px-4 py-1.5 text-xs font-semibold text-slate-300 shadow-xl backdrop-blur-sm"
                        >
                            <span class="relative flex h-2 w-2">
                                <span
                                    class="absolute inline-flex h-full w-full animate-ping rounded-full bg-[#10B981] opacity-75"
                                ></span>
                                <span
                                    class="relative inline-flex h-2 w-2 rounded-full bg-[#10B981]"
                                ></span>
                            </span>
                            <span>Tersedia untuk Pekerjaan Baru</span>
                        </div>

                        <!-- Heading (Bold name as focal point, not full gradient) -->
                        <h1
                            class="font-heading text-4xl leading-tight font-extrabold tracking-tight text-slate-300 sm:text-5xl lg:text-6xl lg:leading-[1.15]"
                        >
                            Hai, Saya
                            <span
                                class="relative mt-2 block font-black tracking-tight text-white drop-shadow-md"
                            >
                                {{ identitas.nama_lengkap }}
                            </span>
                        </h1>

                        <!-- Profession (Developer-oriented badge) -->
                        <div
                            class="inline-flex items-center gap-2 rounded-lg border border-slate-800 bg-slate-900/60 px-4 py-2 shadow-inner"
                        >
                            <div
                                class="h-2 w-2 rounded-full bg-[#2563EB]"
                            ></div>
                            <p
                                class="font-heading text-sm font-bold tracking-wider text-sky-400 uppercase sm:text-base"
                            >
                                {{ identitas.profesi }}
                            </p>
                        </div>

                        <!-- About text -->
                        <p
                            class="mx-auto max-w-xl text-base leading-relaxed text-slate-300 lg:mx-0 lg:text-lg"
                        >
                            {{
                                identitas.tentang_saya ||
                                'Halo! Saya adalah seorang profesional yang berfokus pada pembangunan solusi digital premium.'
                            }}
                        </p>

                        <!-- CTA Buttons -->
                        <div
                            class="flex flex-wrap items-center justify-center gap-4 pt-2 lg:justify-start"
                        >
                            <a
                                v-if="identitas.cv_file"
                                :href="`/storage/${identitas.cv_file}`"
                                target="_blank"
                                class="group relative inline-flex items-center gap-2.5 overflow-hidden rounded-lg bg-[#2563EB] px-6 py-3.5 text-sm font-semibold text-white shadow-lg shadow-blue-500/30 transition-all duration-300 hover:-translate-y-0.5 hover:bg-blue-700 hover:shadow-xl hover:shadow-blue-600/40 focus-visible:ring-2 focus-visible:ring-blue-500 focus-visible:ring-offset-2 focus-visible:outline-none active:scale-[0.97]"
                            >
                                <span
                                    class="relative z-10 flex items-center gap-2.5"
                                >
                                    <FileDown class="h-4 w-4" />
                                    <span>Unduh CV</span>
                                </span>
                            </a>
                            <a
                                href="#contact"
                                class="group relative inline-flex items-center gap-2.5 rounded-lg border border-slate-700/80 bg-slate-900/40 px-6 py-3.5 text-sm font-semibold text-slate-200 shadow-sm backdrop-blur-sm transition-all duration-300 hover:-translate-y-0.5 hover:border-slate-600 hover:bg-slate-800 hover:text-white focus-visible:ring-2 focus-visible:ring-blue-500 focus-visible:ring-offset-2 focus-visible:outline-none active:scale-[0.97]"
                            >
                                <span>Hubungi Saya</span>
                                <ArrowRight
                                    class="h-4 w-4 text-[#0EA5E9] transition-transform duration-300 group-hover:translate-x-1"
                                />
                            </a>
                        </div>
                    </div>

                    <!-- Right visual column (45% / 5 cols) -->
                    <div
                        class="section-reveal flex justify-center lg:col-span-5 lg:justify-end"
                        style="transition-delay: 0.15s"
                    >
                        <div class="relative w-full max-w-sm">
                            <!-- Outer decorative elements for the developer badge -->
                            <div
                                class="pointer-events-none absolute -top-3 -right-3 h-12 w-12 rounded-tr-lg border-t-2 border-r-2 border-slate-700 opacity-40"
                            ></div>
                            <div
                                class="pointer-events-none absolute -bottom-3 -left-3 h-12 w-12 rounded-bl-lg border-b-2 border-l-2 border-slate-700 opacity-40"
                            ></div>

                            <!-- Profile Card -->
                            <div
                                class="relative overflow-hidden rounded-xl border border-slate-800 bg-slate-900/80 p-5 shadow-2xl backdrop-blur-md"
                            >
                                <!-- Terminal / Widget Header -->
                                <div
                                    class="mb-4 flex items-center justify-between border-b border-slate-800/80 pb-3"
                                >
                                    <div class="flex items-center gap-1.5">
                                        <span
                                            class="h-2.5 w-2.5 rounded-full bg-[#EF4444]/90"
                                        ></span>
                                        <span
                                            class="h-2.5 w-2.5 rounded-full bg-[#F59E0B]/90"
                                        ></span>
                                        <span
                                            class="h-2.5 w-2.5 rounded-full bg-[#10B981]/90"
                                        ></span>
                                    </div>
                                    <span
                                        class="font-mono text-[10px] tracking-wider text-slate-500"
                                        >developer.sys</span
                                    >
                                </div>

                                <!-- Avatar image block (rectangular, slightly rounded, clean border) -->
                                <div
                                    class="relative mb-4 aspect-square w-full overflow-hidden rounded-lg border border-slate-800 bg-slate-950 shadow-inner"
                                >
                                    <img
                                        v-if="identitas.foto_profil"
                                        :src="`/storage/${identitas.foto_profil}`"
                                        alt="Avatar Profil"
                                        class="h-full w-full object-cover grayscale-[10%] transition-all duration-500 hover:scale-105 hover:grayscale-0"
                                    />
                                    <span
                                        v-else
                                        class="flex h-full w-full items-center justify-center font-heading text-6xl font-bold text-slate-700"
                                    >
                                        {{ identitas.nama_lengkap.charAt(0) }}
                                    </span>
                                </div>

                                <!-- Info and dynamic stats -->
                                <div class="space-y-4">
                                    <div
                                        class="flex items-center justify-between"
                                    >
                                        <div>
                                            <h3
                                                class="text-left text-base font-bold tracking-tight text-white"
                                            >
                                                {{ identitas.nama_lengkap }}
                                            </h3>
                                            <p
                                                class="mt-0.5 text-left font-mono text-[11px] tracking-wider text-[#0EA5E9]"
                                            >
                                                {{ identitas.profesi }}
                                            </p>
                                        </div>
                                        <div
                                            class="inline-flex items-center gap-1.5 rounded-full border border-[#10B981]/25 bg-[#10B981]/10 px-2.5 py-1 font-mono text-[9px] font-bold text-[#10B981] shadow-sm"
                                        >
                                            <span
                                                class="relative flex h-1.5 w-1.5"
                                            >
                                                <span
                                                    class="absolute inline-flex h-full w-full animate-ping rounded-full bg-[#10B981] opacity-75"
                                                ></span>
                                                <span
                                                    class="relative inline-flex h-1.5 w-1.5 rounded-full bg-[#10B981]"
                                                ></span>
                                            </span>
                                            <span>ONLINE</span>
                                        </div>
                                    </div>

                                    <!-- Technical stats grid -->
                                    <div
                                        class="grid grid-cols-2 gap-3 border-t border-slate-800/80 pt-3"
                                    >
                                        <div
                                            class="rounded-lg border border-slate-800/60 bg-slate-950/40 p-2.5 text-center"
                                        >
                                            <span
                                                class="block font-mono text-[9px] tracking-wider text-slate-500 uppercase"
                                                >Portfolio</span
                                            >
                                            <span
                                                class="mt-0.5 block font-mono text-xs font-bold text-white sm:text-sm"
                                                >{{
                                                    portofolio.length
                                                }}
                                                Proyek</span
                                            >
                                        </div>
                                        <div
                                            class="rounded-lg border border-slate-800/60 bg-slate-950/40 p-2.5 text-center"
                                        >
                                            <span
                                                class="block font-mono text-[9px] tracking-wider text-slate-500 uppercase"
                                                >Expertise</span
                                            >
                                            <span
                                                class="mt-0.5 block font-mono text-xs font-bold text-[#0EA5E9] sm:text-sm"
                                                >{{
                                                    skills.length
                                                }}
                                                Skills</span
                                            >
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Bottom fade gradient (smooth transition to the next section) -->
            <div
                class="absolute right-0 bottom-0 left-0 h-24 bg-gradient-to-t from-[#F8FAFC] to-transparent dark:from-[#09090b]"
            ></div>
        </section>

        <!-- ==================== ABOUT SECTION ==================== -->
        <section id="about" class="relative py-20 sm:py-28">
            <!-- Subtle background -->
            <div
                class="absolute inset-0 bg-gradient-to-b from-transparent via-blue-50/30 to-transparent dark:via-blue-950/10"
            ></div>

            <div class="relative mx-auto max-w-6xl px-4 sm:px-6 lg:px-8">
                <!-- Section header -->
                <div
                    class="section-reveal mx-auto max-w-2xl space-y-4 text-center"
                >
                    <div
                        class="inline-flex items-center gap-2 rounded-full bg-blue-100/80 px-3 py-1 text-xs font-semibold text-blue-700 dark:bg-blue-900/30 dark:text-blue-400"
                    >
                        <Star class="h-3 w-3" />
                        <span>Tentang Saya</span>
                    </div>
                    <h2
                        class="font-heading text-3xl font-bold tracking-tight text-[#0F172A] sm:text-4xl dark:text-white"
                    >
                        Kenali Saya Lebih Dekat
                    </h2>
                    <p
                        class="text-sm leading-relaxed text-neutral-500 dark:text-neutral-400"
                    >
                        Misi, keahlian, dan filosofi kerja saya dalam membangun
                        solusi digital.
                    </p>
                </div>

                <div class="mx-auto mt-12 grid max-w-4xl gap-6 md:grid-cols-2">
                    <!-- Card 1: Siapa Saya -->
                    <div
                        class="group section-reveal card-premium relative overflow-hidden rounded-2xl border border-neutral-100/80 bg-white p-8 shadow-sm transition-all duration-500 hover:-translate-y-1 hover:shadow-xl dark:border-neutral-800/50 dark:bg-[#0c0c0e] dark:hover:shadow-blue-900/10"
                    >
                        <div
                            class="absolute inset-0 bg-gradient-to-br from-blue-600/[0.02] to-transparent opacity-0 transition-opacity duration-500 group-hover:opacity-100"
                        ></div>
                        <div class="relative space-y-4">
                            <div
                                class="flex h-12 w-12 items-center justify-center rounded-xl bg-gradient-to-br from-blue-500 to-blue-600 text-white shadow-lg shadow-blue-500/20"
                            >
                                <Quote class="h-5 w-5" />
                            </div>
                            <h3
                                class="font-heading text-lg font-bold text-[#0F172A] dark:text-white"
                            >
                                Siapa Saya?
                            </h3>
                            <p
                                class="text-sm leading-relaxed whitespace-pre-wrap text-neutral-600 dark:text-neutral-400"
                            >
                                {{
                                    identitas.tentang_saya ||
                                    'Saya adalah seorang developer yang berdedikasi tinggi untuk menciptakan kode bersih, performa unggul, dan desain pengalaman pengguna yang maksimal.'
                                }}
                            </p>
                        </div>
                    </div>

                    <!-- Card 2: Filosofi Kerja -->
                    <div
                        class="group section-reveal card-premium relative overflow-hidden rounded-2xl border border-neutral-100/80 bg-white p-8 shadow-sm transition-all duration-500 hover:-translate-y-1 hover:shadow-xl dark:border-neutral-800/50 dark:bg-[#0c0c0e] dark:hover:shadow-teal-900/10"
                    >
                        <div
                            class="absolute inset-0 bg-gradient-to-br from-teal-600/[0.02] to-transparent opacity-0 transition-opacity duration-500 group-hover:opacity-100"
                        ></div>
                        <div class="relative space-y-4">
                            <div
                                class="flex h-12 w-12 items-center justify-center rounded-xl bg-gradient-to-br from-teal-500 to-emerald-600 text-white shadow-lg shadow-teal-500/20"
                            >
                                <Target class="h-5 w-5" />
                            </div>
                            <h3
                                class="font-heading text-lg font-bold text-[#0F172A] dark:text-white"
                            >
                                Filosofi Kerja
                            </h3>
                            <p
                                class="text-sm leading-relaxed text-neutral-600 dark:text-neutral-400"
                            >
                                Membangun aplikasi digital bukan hanya sekadar
                                menulis kode, tetapi juga tentang memecahkan
                                masalah nyata dan memberikan dampak positif
                                serta kemudahan bagi penggunanya secara estetis
                                dan fungsional.
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- ==================== SKILLS SECTION ==================== -->
        <section
            v-if="skills.length > 0"
            id="skills"
            class="relative overflow-hidden py-20 sm:py-28"
        >
            <div
                class="absolute inset-0 bg-gradient-to-b from-blue-50/20 via-transparent to-teal-50/20 dark:from-blue-950/5 dark:via-transparent dark:to-teal-950/5"
            ></div>

            <div class="relative mx-auto max-w-6xl px-4 sm:px-6 lg:px-8">
                <!-- Section header -->
                <div
                    class="section-reveal mx-auto max-w-2xl space-y-4 text-center"
                >
                    <div
                        class="inline-flex items-center gap-2 rounded-full bg-teal-100/80 px-3 py-1 text-xs font-semibold text-teal-700 dark:bg-teal-900/30 dark:text-teal-400"
                    >
                        <Zap class="h-3 w-3" />
                        <span>Keahlian</span>
                    </div>
                    <h2
                        class="font-heading text-3xl font-bold tracking-tight text-[#0F172A] sm:text-4xl dark:text-white"
                    >
                        Teknologi yang Saya Kuasai
                    </h2>
                    <p
                        class="text-sm leading-relaxed text-neutral-500 dark:text-neutral-400"
                    >
                        Berbagai teknologi dan alat yang saya gunakan dalam
                        pengembangan proyek.
                    </p>
                </div>
            </div>

            <!-- Infinite Slider -->
            <div
                class="skills-slider mt-14"
                :class="{ 'skills-paused': isSkillsPaused }"
                @mouseenter="isSkillsPaused = true"
                @mouseleave="isSkillsPaused = false"
            >
                <div class="skills-track">
                    <div
                        v-for="(skill, index) in skills"
                        :key="'a-' + skill.id"
                        class="skills-card group"
                        :style="{ animationDelay: `${index * 0.05}s` }"
                    >
                        <div class="skills-icon-wrapper">
                            <img
                                v-if="skill.gambar"
                                :src="`/storage/${skill.gambar}`"
                                :alt="skill.nama"
                                class="skills-icon"
                                loading="lazy"
                            />
                            <Code2
                                v-else
                                class="skills-icon text-blue-600 dark:text-blue-400"
                            />
                        </div>
                        <div class="skills-tooltip">{{ skill.nama }}</div>
                    </div>
                    <!-- Duplicate for seamless loop -->
                    <div
                        v-for="(skill, index) in skills"
                        :key="'b-' + skill.id"
                        class="skills-card group"
                        :style="{ animationDelay: `${index * 0.05}s` }"
                    >
                        <div class="skills-icon-wrapper">
                            <img
                                v-if="skill.gambar"
                                :src="`/storage/${skill.gambar}`"
                                :alt="skill.nama"
                                class="skills-icon"
                                loading="lazy"
                            />
                            <Code2
                                v-else
                                class="skills-icon text-blue-600 dark:text-blue-400"
                            />
                        </div>
                        <div class="skills-tooltip">{{ skill.nama }}</div>
                    </div>
                </div>
            </div>
        </section>

        <!-- ==================== TIMELINE SECTION ==================== -->
        <section
            id="timeline"
            class="relative bg-white py-20 sm:py-28 dark:bg-[#0c0c0e]"
        >
            <div
                class="absolute inset-0 bg-gradient-to-b from-blue-50/20 via-transparent to-teal-50/20 dark:from-blue-950/5 dark:via-transparent dark:to-teal-950/5"
            ></div>

            <div class="relative mx-auto max-w-6xl px-4 sm:px-6 lg:px-8">
                <!-- Section header -->
                <div
                    class="section-reveal mx-auto max-w-2xl space-y-4 text-center"
                >
                    <div
                        class="inline-flex items-center gap-2 rounded-full bg-purple-100/80 px-3 py-1 text-xs font-semibold text-purple-700 dark:bg-purple-900/30 dark:text-purple-400"
                    >
                        <GraduationCap class="h-3 w-3" />
                        <span>Perjalanan Saya</span>
                    </div>
                    <h2
                        class="font-heading text-3xl font-bold tracking-tight text-[#0F172A] sm:text-4xl dark:text-white"
                    >
                        Pendidikan & Pengalaman
                    </h2>
                    <p
                        class="text-sm leading-relaxed text-neutral-500 dark:text-neutral-400"
                    >
                        Jejak akademis dan perjalanan karir profesional saya
                        secara kronologis.
                    </p>
                </div>

                <div
                    class="mx-auto mt-14 grid max-w-5xl gap-12 lg:grid-cols-2 lg:gap-16"
                >
                    <!-- Pendidikan Timeline -->
                    <div class="section-reveal space-y-6">
                        <div class="flex items-center gap-3">
                            <div
                                class="flex h-10 w-10 items-center justify-center rounded-xl bg-gradient-to-br from-purple-500 to-purple-600 text-white shadow-lg shadow-purple-500/20"
                            >
                                <GraduationCap class="h-5 w-5" />
                            </div>
                            <h3
                                class="font-heading text-xl font-bold text-[#0F172A] dark:text-white"
                            >
                                Pendidikan
                            </h3>
                            <div
                                class="ml-auto hidden h-px flex-1 bg-gradient-to-r from-purple-200 to-transparent sm:block dark:from-purple-900/50"
                            ></div>
                        </div>

                        <div
                            class="relative ml-5 space-y-8 border-l-2 border-neutral-200 dark:border-neutral-800"
                        >
                            <div
                                v-if="pendidikan.length === 0"
                                class="pl-8 text-sm text-neutral-400 italic"
                            >
                                Belum ada riwayat pendidikan.
                            </div>
                            <div
                                v-for="item in pendidikan"
                                :key="item.id"
                                class="group relative pl-8 transition-all duration-300"
                            >
                                <!-- Timeline dot -->
                                <div
                                    class="absolute top-1.5 -left-[13px] flex h-6 w-6 items-center justify-center rounded-full border-[3px] border-white bg-gradient-to-br from-purple-500 to-purple-600 shadow-md transition-all duration-300 group-hover:scale-125 group-hover:shadow-lg dark:border-[#09090b]"
                                >
                                    <div
                                        class="h-1.5 w-1.5 rounded-full bg-white"
                                    ></div>
                                </div>

                                <div
                                    class="space-y-2.5 rounded-xl border border-neutral-100 bg-neutral-50/50 p-5 transition-all duration-300 group-hover:border-purple-200 group-hover:shadow-md dark:border-neutral-800/50 dark:bg-neutral-900/20 dark:group-hover:border-purple-800/50"
                                >
                                    <div
                                        class="flex flex-wrap items-center gap-2"
                                    >
                                        <span
                                            class="inline-flex items-center gap-1 rounded-lg bg-gradient-to-r from-purple-500 to-purple-600 px-2.5 py-1 text-[11px] font-semibold text-white shadow-sm"
                                        >
                                            <Calendar class="h-3 w-3" />
                                            {{ item.tahun_mulai }} -
                                            {{
                                                item.tahun_selesai || 'Sekarang'
                                            }}
                                        </span>
                                    </div>
                                    <h4
                                        class="font-heading text-base font-bold text-[#0F172A] dark:text-white"
                                    >
                                        {{ item.gelar_jurusan }}
                                    </h4>
                                    <p
                                        class="text-sm font-medium text-blue-600 dark:text-blue-400"
                                    >
                                        {{ item.institusi }}
                                    </p>
                                    <p
                                        v-if="item.deskripsi"
                                        class="pt-1 text-sm leading-relaxed whitespace-pre-wrap text-neutral-500 dark:text-neutral-400"
                                    >
                                        {{ item.deskripsi }}
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Pengalaman Timeline -->
                    <div
                        class="section-reveal space-y-6"
                        style="transition-delay: 0.15s"
                    >
                        <div class="flex items-center gap-3">
                            <div
                                class="flex h-10 w-10 items-center justify-center rounded-xl bg-gradient-to-br from-emerald-500 to-teal-600 text-white shadow-lg shadow-emerald-500/20"
                            >
                                <Briefcase class="h-5 w-5" />
                            </div>
                            <h3
                                class="font-heading text-xl font-bold text-[#0F172A] dark:text-white"
                            >
                                Pengalaman
                            </h3>
                            <div
                                class="ml-auto hidden h-px flex-1 bg-gradient-to-r from-emerald-200 to-transparent sm:block dark:from-emerald-900/50"
                            ></div>
                        </div>

                        <div
                            class="relative ml-5 space-y-8 border-l-2 border-neutral-200 dark:border-neutral-800"
                        >
                            <div
                                v-if="pengalaman.length === 0"
                                class="pl-8 text-sm text-neutral-400 italic"
                            >
                                Belum ada riwayat pengalaman.
                            </div>
                            <div
                                v-for="item in pengalaman"
                                :key="item.id"
                                class="group relative pl-8 transition-all duration-300"
                            >
                                <!-- Timeline dot -->
                                <div
                                    class="absolute top-1.5 -left-[13px] flex h-6 w-6 items-center justify-center rounded-full border-[3px] border-white bg-gradient-to-br from-emerald-500 to-teal-600 shadow-md transition-all duration-300 group-hover:scale-125 group-hover:shadow-lg dark:border-[#09090b]"
                                >
                                    <div
                                        class="h-1.5 w-1.5 rounded-full bg-white"
                                    ></div>
                                </div>

                                <div
                                    class="space-y-2.5 rounded-xl border border-neutral-100 bg-neutral-50/50 p-5 transition-all duration-300 group-hover:border-emerald-200 group-hover:shadow-md dark:border-neutral-800/50 dark:bg-neutral-900/20 dark:group-hover:border-emerald-800/50"
                                >
                                    <div
                                        class="flex flex-wrap items-center gap-2"
                                    >
                                        <span
                                            :class="[
                                                'inline-flex items-center gap-1 rounded-lg border px-2.5 py-1 text-[11px] font-semibold shadow-sm',
                                                getBadgeColor(item.kategori),
                                            ]"
                                        >
                                            {{ item.kategori }}
                                        </span>
                                        <span
                                            class="flex items-center gap-1 text-[11px] font-medium text-neutral-500 dark:text-neutral-400"
                                        >
                                            <Calendar class="h-3 w-3" />
                                            {{ formatDate(item.tanggal_mulai) }}
                                            -
                                            {{
                                                formatDate(item.tanggal_selesai)
                                            }}
                                        </span>
                                    </div>
                                    <h4
                                        class="font-heading text-base font-bold text-[#0F172A] dark:text-white"
                                    >
                                        {{ item.posisi }}
                                    </h4>
                                    <p
                                        class="text-sm font-medium text-blue-600 dark:text-blue-400"
                                    >
                                        {{ item.nama_instansi }}
                                    </p>
                                    <p
                                        v-if="item.deskripsi"
                                        class="pt-1 text-sm leading-relaxed whitespace-pre-wrap text-neutral-500 dark:text-neutral-400"
                                    >
                                        {{ item.deskripsi }}
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- ==================== PROJECTS SECTION ==================== -->
        <section id="projects" class="relative py-16 sm:py-20">
            <!-- Background gradient -->
            <div
                class="absolute inset-0 bg-gradient-to-b from-transparent via-blue-50/20 to-transparent dark:via-blue-950/5"
            ></div>

            <!-- Decorative grid pattern -->
            <div
                class="pointer-events-none absolute inset-0 bg-[linear-gradient(rgba(37,99,235,0.02)_1px,transparent_1px),linear-gradient(to_right,rgba(37,99,235,0.02)_1px,transparent_1px)] bg-[size:48px_48px] dark:bg-[linear-gradient(rgba(59,130,246,0.03)_1px,transparent_1px),linear-gradient(to_right,rgba(59,130,246,0.03)_1px,transparent_1px)]"
            ></div>

            <!-- Decorative glow orbs -->
            <div class="pointer-events-none absolute inset-0 overflow-hidden">
                <div
                    class="absolute -top-24 -right-24 h-[500px] w-[500px] rounded-full bg-gradient-to-br from-blue-500/5 to-transparent blur-3xl dark:from-blue-500/10"
                ></div>
                <div
                    class="absolute -bottom-24 -left-24 h-[400px] w-[400px] rounded-full bg-gradient-to-tr from-teal-500/5 to-transparent blur-3xl dark:from-teal-500/10"
                ></div>
            </div>

            <div class="relative mx-auto max-w-6xl px-4 sm:px-6 lg:px-8">
                <!-- Section header -->
                <div
                    class="section-reveal mx-auto max-w-2xl text-center"
                >
                    <div
                        class="inline-flex items-center gap-2 rounded-full bg-blue-100/80 px-3 py-1 text-xs font-semibold text-blue-700 dark:bg-blue-900/30 dark:text-blue-400"
                    >
                        <FolderGit2 class="h-3 w-3" />
                        <span>Portofolio</span>
                    </div>
                    <h2
                        class="mt-4 font-heading text-3xl font-bold tracking-tight text-[#0F172A] sm:text-4xl dark:text-white"
                    >
                        Galeri Portofolio
                    </h2>
                    <div
                        class="mx-auto mt-3 h-1 w-16 rounded-full bg-gradient-to-r from-blue-500/40 to-teal-500/40 dark:from-blue-400/30 dark:to-teal-400/30"
                    ></div>
                    <p
                        class="mt-4 text-sm leading-relaxed text-neutral-500 dark:text-neutral-400"
                    >
                        Kumpulan proyek inovatif dan solusi digital yang telah
                        saya buat.
                    </p>
                </div>

                <div
                    class="mx-auto mt-10 grid max-w-5xl gap-6 sm:mt-12 sm:grid-cols-2 lg:grid-cols-3"
                >
                    <div
                        v-if="portofolio.length === 0"
                        class="col-span-full rounded-2xl border-2 border-dashed border-neutral-200 p-16 text-center text-neutral-400 italic dark:border-neutral-700"
                    >
                        <FolderGit2
                            class="mx-auto mb-3 h-8 w-8 text-neutral-300 dark:text-neutral-600"
                        />
                        Belum ada proyek portofolio yang ditampilkan.
                    </div>

                    <div
                        v-for="(project, index) in portofolio"
                        :key="project.id"
                        @click="openDetail(project)"
                        class="group section-reveal card-premium relative flex cursor-pointer flex-col overflow-hidden rounded-2xl border border-neutral-100/80 bg-white shadow-sm transition-all duration-500 hover:-translate-y-2 hover:shadow-xl hover:shadow-blue-600/5 dark:border-neutral-800/50 dark:bg-[#0c0c0e] dark:hover:shadow-blue-600/10"
                        :style="{ transitionDelay: `${index * 0.1}s` }"
                    >
                        <!-- Thumbnail -->
                        <div
                            class="relative aspect-video w-full overflow-hidden bg-neutral-100 dark:bg-neutral-800"
                        >
                            <img
                                v-if="project.thumbnail"
                                :src="`/storage/${project.thumbnail}`"
                                alt="Thumbnail proyek"
                                class="h-full w-full object-cover transition-all duration-700 group-hover:scale-110"
                            />
                            <div
                                v-else
                                class="flex h-full w-full items-center justify-center bg-gradient-to-br from-neutral-100 to-neutral-200 text-xs text-neutral-400 italic dark:from-neutral-800 dark:to-neutral-900"
                            >
                                <div class="flex flex-col items-center gap-2">
                                    <FolderGit2
                                        class="h-8 w-8 text-neutral-300 dark:text-neutral-600"
                                    />
                                    <span class="text-[11px] font-medium"
                                        >Pratinjau Gambar</span
                                    >
                                </div>
                            </div>

                            <!-- Hover overlay -->
                            <div
                                class="absolute inset-0 flex items-center justify-center bg-gradient-to-t from-black/70 via-black/20 to-transparent opacity-0 transition-opacity duration-400 group-hover:opacity-100"
                            >
                                <span
                                    class="inline-flex translate-y-4 items-center gap-1.5 rounded-xl bg-white/90 px-4 py-2 text-xs font-bold text-[#0F172A] shadow-lg backdrop-blur-sm transition-all duration-300 group-hover:translate-y-0 dark:bg-[#18181b]/90 dark:text-white"
                                >
                                    Lihat Detail
                                    <ArrowUpRight class="h-3.5 w-3.5" />
                                </span>
                            </div>

                            <!-- Featured badge (first project) -->
                            <div
                                v-if="index === 0"
                                class="absolute top-3 left-3 inline-flex items-center gap-1 rounded-lg bg-gradient-to-r from-amber-400 to-amber-500 px-2 py-1 text-[10px] font-bold text-amber-950 shadow-md"
                            >
                                <Star class="h-3 w-3" />
                                Unggulan
                            </div>
                        </div>

                        <!-- Content -->
                        <div class="flex flex-1 flex-col p-5 sm:p-6">
                            <h3
                                class="line-clamp-1 font-heading text-base leading-snug font-bold text-[#0F172A] transition-colors duration-300 group-hover:text-blue-600 dark:text-white dark:group-hover:text-blue-400"
                            >
                                {{ project.judul_proyek }}
                            </h3>
                            <p
                                class="mt-2 line-clamp-2 text-sm leading-relaxed text-neutral-500 dark:text-neutral-400"
                            >
                                {{ project.deskripsi_singkat }}
                            </p>

                            <!-- Tech badges -->
                            <div
                                v-if="project.tools && project.tools.length > 0"
                                class="mt-auto flex flex-wrap gap-1.5 pt-4"
                            >
                                <span
                                    v-for="(tool, i) in project.tools.slice(
                                        0,
                                        4,
                                    )"
                                    :key="i"
                                    :class="[
                                        'inline-flex items-center rounded-md px-2 py-0.5 text-[10px] font-medium',
                                        getTechBadgeColor(i),
                                    ]"
                                >
                                    <div
                                        class="mr-1 h-1 w-1 rounded-full"
                                        :class="
                                            'bg-' +
                                            [
                                                'blue-500',
                                                'purple-500',
                                                'emerald-500',
                                                'amber-500',
                                            ][i % 4]
                                        "
                                    ></div>
                                    {{ tool }}
                                </span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- ==================== FOOTER / CONTACT ==================== -->
        <footer
            id="contact"
            class="relative bg-[#0B1120] text-neutral-400 dark:bg-[#060608]"
        >
            <!-- Gradient top border -->
            <div
                class="absolute top-0 right-0 left-0 h-px bg-gradient-to-r from-transparent via-blue-500/50 to-transparent"
            ></div>

            <!-- Background pattern -->
            <div class="absolute inset-0 opacity-[0.02]">
                <div
                    class="absolute inset-0"
                    style="
                        background-image: radial-gradient(
                            circle at 1px 1px,
                            white 1px,
                            transparent 0
                        );
                        background-size: 40px 40px;
                    "
                ></div>
            </div>

            <div
                class="relative mx-auto max-w-6xl px-4 py-16 sm:px-6 sm:py-20 lg:px-8 lg:py-24"
            >
                <!-- Top section -->
                <div
                    class="flex flex-col items-center justify-between gap-10 border-b border-neutral-800/60 pb-12 md:flex-row md:gap-8"
                >
                    <div class="max-w-md space-y-4 text-center md:text-left">
                        <h2
                            class="font-heading text-3xl font-bold tracking-tight text-white sm:text-4xl"
                        >
                            Hubungi Saya
                        </h2>
                        <p class="text-sm leading-relaxed text-neutral-400">
                            Tertarik untuk berkolaborasi atau memiliki
                            pertanyaan? Hubungi saya melalui salah satu tautan
                            media sosial atau platform di bawah ini.
                        </p>
                    </div>

                    <!-- Social Icons -->
                    <div
                        class="flex flex-wrap items-center justify-center gap-3"
                    >
                        <a
                            v-for="item in kontak"
                            :key="item.id"
                            :href="item.url"
                            target="_blank"
                            class="group relative flex h-12 w-12 items-center justify-center rounded-xl bg-neutral-800/50 text-neutral-300 transition-all duration-300 hover:bg-blue-600 hover:text-white hover:shadow-lg hover:shadow-blue-600/25 focus-visible:ring-2 focus-visible:ring-blue-500 focus-visible:ring-offset-2 focus-visible:ring-offset-neutral-900 focus-visible:outline-none active:scale-90"
                            :title="item.platform"
                        >
                            <span
                                class="absolute -inset-1 rounded-xl bg-blue-600/20 opacity-0 blur-md transition-opacity duration-300 group-hover:opacity-100"
                            ></span>
                            <!-- Github -->
                            <svg
                                v-if="
                                    item.platform
                                        .toLowerCase()
                                        .includes('github')
                                "
                                class="relative h-5 w-5"
                                fill="currentColor"
                                viewBox="0 0 24 24"
                            >
                                <path
                                    d="M12 2C6.477 2 2 6.477 2 12c0 4.42 2.865 8.166 6.839 9.489.5.092.682-.217.682-.482 0-.237-.008-.866-.013-1.7-2.782.603-3.369-1.34-3.369-1.34-.454-1.156-1.11-1.462-1.11-1.462-.908-.62.069-.608.069-.608 1.003.07 1.531 1.03 1.531 1.03.892 1.529 2.341 1.087 2.91.831.092-.646.35-1.086.636-1.336-2.22-.253-4.555-1.11-4.555-4.943 0-1.091.39-1.984 1.029-2.683-.103-.253-.446-1.27.098-2.647 0 0 .84-.269 2.75 1.025A9.564 9.564 0 0112 6.844c.85.004 1.705.115 2.504.337 1.909-1.294 2.747-1.025 2.747-1.025.546 1.377.203 2.394.1 2.647.64.699 1.028 1.592 1.028 2.683 0 3.842-2.339 4.687-4.566 4.935.359.309.678.919.678 1.852 0 1.336-.012 2.415-.012 2.743 0 .267.18.577.688.479C19.138 20.164 22 16.418 22 12c0-5.523-4.477-10-10-10z"
                                />
                            </svg>
                            <!-- Linkedin -->
                            <svg
                                v-else-if="
                                    item.platform
                                        .toLowerCase()
                                        .includes('linkedin')
                                "
                                class="relative h-5 w-5"
                                fill="currentColor"
                                viewBox="0 0 24 24"
                            >
                                <path
                                    d="M19 0h-14c-2.761 0-5 2.239-5 5v14c0 2.761 2.239 5 5 5h14c2.762 0 5-2.239 5-5v-14c0-2.761-2.238-5-5-5zm-11 19h-3v-11h3v11zm-1.5-12.268c-.966 0-1.75-.779-1.75-1.75s.784-1.75 1.75-1.75 1.75.779 1.75 1.75-.784 1.75-1.75 1.75zm13.5 12.268h-3v-5.604c0-3.368-4-3.113-4 0v5.604h-3v-11h3v1.765c1.396-2.586 7-2.777 7 2.476v6.759z"
                                />
                            </svg>
                            <!-- Twitter -->
                            <svg
                                v-else-if="
                                    item.platform
                                        .toLowerCase()
                                        .includes('twitter') ||
                                    item.platform.toLowerCase().includes('x')
                                "
                                class="relative h-5 w-5"
                                fill="currentColor"
                                viewBox="0 0 24 24"
                            >
                                <path
                                    d="M18.244 2.25h3.308l-7.227 8.26 8.502 11.24H16.17l-5.214-6.817L4.99 21.75H1.68l7.73-8.835L1.254 2.25H8.08l4.713 6.231zm-1.161 17.52h1.833L7.084 4.126H5.117z"
                                />
                            </svg>
                            <!-- Instagram -->
                            <svg
                                v-else-if="
                                    item.platform
                                        .toLowerCase()
                                        .includes('instagram')
                                "
                                class="relative h-5 w-5"
                                fill="none"
                                stroke="currentColor"
                                stroke-width="2"
                                stroke-linecap="round"
                                stroke-linejoin="round"
                                viewBox="0 0 24 24"
                            >
                                <rect
                                    x="2"
                                    y="2"
                                    width="20"
                                    height="20"
                                    rx="5"
                                    ry="5"
                                ></rect>
                                <path
                                    d="M16 11.37A4 4 0 1 1 12.63 8 4 4 0 0 1 16 11.37z"
                                ></path>
                                <line
                                    x1="17.5"
                                    y1="6.5"
                                    x2="17.51"
                                    y2="6.5"
                                ></line>
                            </svg>
                            <!-- Email -->
                            <svg
                                v-else-if="
                                    item.platform
                                        .toLowerCase()
                                        .includes('mail') ||
                                    item.platform
                                        .toLowerCase()
                                        .includes('email')
                                "
                                class="relative h-5 w-5"
                                fill="none"
                                stroke="currentColor"
                                stroke-width="2"
                                stroke-linecap="round"
                                stroke-linejoin="round"
                                viewBox="0 0 24 24"
                            >
                                <path
                                    d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z"
                                ></path>
                                <polyline points="22,6 12,13 2,6"></polyline>
                            </svg>
                            <!-- Default -->
                            <component
                                v-else
                                :is="LinkIcon"
                                class="relative h-5 w-5"
                            />
                        </a>
                    </div>
                </div>

                <!-- Bottom bar -->
                <div
                    class="flex flex-col items-center justify-between gap-4 pt-8 text-xs sm:flex-row sm:text-sm"
                >
                    <p>
                        &copy; {{ new Date().getFullYear() }}
                        {{ identitas.nama_lengkap }}. Hak Cipta Dilindungi.
                    </p>
                    <div class="flex items-center gap-2 text-neutral-600">
                        <span class="hidden sm:inline">Dibuat dengan</span>
                        <span class="flex items-center gap-1.5">
                            <span
                                class="inline-flex h-5 w-5 items-center justify-center rounded bg-blue-600/10 text-[10px] font-bold text-blue-500"
                                >L</span
                            >
                            <span
                                class="inline-flex h-5 w-5 items-center justify-center rounded bg-emerald-600/10 text-[10px] font-bold text-emerald-500"
                                >V</span
                            >
                            <span
                                class="inline-flex h-5 w-5 items-center justify-center rounded bg-purple-600/10 text-[10px] font-bold text-purple-500"
                                >I</span
                            >
                        </span>
                    </div>
                </div>
            </div>
        </footer>

        <!-- ==================== PROJECT DETAIL DIALOG ==================== -->
        <Dialog :open="isDetailOpen" @update:open="handleDetailClose">
            <DialogContent
                v-if="selectedProject"
                class="flex max-h-[85vh] flex-col gap-0 overflow-hidden rounded-2xl border-neutral-200/80 p-0 shadow-2xl sm:max-w-[600px] dark:border-neutral-800/50"
            >
                <div class="overflow-y-auto p-0">
                    <!-- Thumbnail header -->
                    <div
                        class="relative aspect-video w-full overflow-hidden bg-neutral-100 dark:bg-neutral-800"
                    >
                        <img
                            v-if="selectedProject.thumbnail"
                            :src="`/storage/${selectedProject.thumbnail}`"
                            alt="Project Preview"
                            class="h-full w-full object-contain"
                        />
                        <div
                            v-else
                            class="flex h-full w-full items-center justify-center bg-gradient-to-br from-neutral-100 to-neutral-200 text-sm text-neutral-400 italic dark:from-neutral-800 dark:to-neutral-900"
                        >
                            <div class="flex flex-col items-center gap-2">
                                <FolderGit2
                                    class="h-8 w-8 text-neutral-300 dark:text-neutral-600"
                                />
                                <span>Tidak ada gambar pratinjau</span>
                            </div>
                        </div>
                        <div
                            class="absolute inset-0 bg-gradient-to-t from-black/60 via-transparent to-transparent"
                        ></div>
                    </div>

                    <!-- Content -->
                    <div class="space-y-6 p-6 sm:p-8">
                        <DialogHeader class="space-y-3">
                            <DialogTitle
                                class="font-heading text-xl leading-tight font-bold text-[#0F172A] sm:text-2xl dark:text-white"
                                >{{ selectedProject.judul_proyek }}</DialogTitle
                            >
                            <DialogDescription
                                class="text-sm text-neutral-500 dark:text-neutral-400"
                                >{{
                                    selectedProject.deskripsi_singkat
                                }}</DialogDescription
                            >
                        </DialogHeader>

                        <!-- Tech stack -->
                        <div
                            v-if="
                                selectedProject.tools &&
                                selectedProject.tools.length > 0
                            "
                            class="flex flex-wrap gap-2"
                        >
                            <span
                                v-for="(tech, i) in selectedProject.tools"
                                :key="i"
                                class="inline-flex items-center gap-1 rounded-lg bg-neutral-100 px-3 py-1.5 text-[11px] font-medium text-neutral-700 dark:bg-neutral-800 dark:text-neutral-300"
                            >
                                <div
                                    class="h-1.5 w-1.5 rounded-full"
                                    :class="
                                        [
                                            'bg-emerald-500',
                                            'bg-blue-500',
                                            'bg-cyan-500',
                                            'bg-purple-500',
                                            'bg-amber-500',
                                        ][i % 5]
                                    "
                                ></div>
                                {{ tech }}
                            </span>
                        </div>

                        <!-- Full description -->
                        <div class="space-y-3">
                            <h4
                                class="font-heading text-xs font-bold tracking-widest text-neutral-900 uppercase dark:text-white"
                            >
                                Detail Lengkap
                            </h4>
                            <div
                                class="text-sm leading-relaxed whitespace-pre-wrap text-neutral-600 dark:text-neutral-300"
                            >
                                {{
                                    selectedProject.deskripsi_lengkap ||
                                    'Tidak ada detail lengkap yang disediakan.'
                                }}
                            </div>
                        </div>

                        <DialogFooter
                            class="flex flex-col items-stretch justify-between gap-4 border-t border-neutral-100 pt-5 sm:flex-row sm:items-center dark:border-neutral-800"
                        >
                            <a
                                v-if="selectedProject.link_eksternal"
                                :href="selectedProject.link_eksternal"
                                target="_blank"
                                class="group inline-flex items-center justify-center gap-1.5 rounded-xl bg-blue-600 px-5 py-2.5 text-sm font-semibold text-white shadow-lg shadow-blue-600/20 transition-all duration-300 hover:bg-blue-500 hover:shadow-xl active:scale-[0.97]"
                            >
                                <span>Buka Repository / Demo</span>
                                <ArrowUpRight
                                    class="h-4 w-4 transition-transform duration-300 group-hover:translate-x-0.5 group-hover:-translate-y-0.5"
                                />
                            </a>
                            <Button
                                type="button"
                                variant="outline"
                                @click="isDetailOpen = false"
                                class="rounded-xl border-neutral-200 dark:border-neutral-700"
                                >Tutup</Button
                            >
                        </DialogFooter>
                    </div>
                </div>
            </DialogContent>
        </Dialog>
    </div>
</template>
