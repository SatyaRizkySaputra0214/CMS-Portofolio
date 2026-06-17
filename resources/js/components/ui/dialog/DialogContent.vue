<script setup lang="ts">
import type { DialogContentEmits, DialogContentProps } from "reka-ui"
import type { HTMLAttributes } from "vue"
import { X } from "@lucide/vue"
import { onMounted, onUnmounted } from "vue"
import { reactiveOmit, useScrollLock, useMutationObserver } from "@vueuse/core"
import {
  DialogClose,
  DialogContent,
  DialogPortal,
  useForwardPropsEmits,
} from "reka-ui"
import { cn } from "@/lib/utils"
import DialogOverlay from "./DialogOverlay.vue"

defineOptions({
  inheritAttrs: false,
})

const props = withDefaults(defineProps<DialogContentProps & { class?: HTMLAttributes["class"], showCloseButton?: boolean }>(), {
  showCloseButton: true,
})
const emits = defineEmits<DialogContentEmits>()

const delegatedProps = reactiveOmit(props, "class")

const forwarded = useForwardPropsEmits(delegatedProps, emits)

const isLocked = useScrollLock(document.body)

function syncScrollLock() {
  const openDialog = document.querySelector('[data-slot="dialog-content"][data-state="open"]')
  isLocked.value = !!openDialog
}

onMounted(() => {
  syncScrollLock()
})

useMutationObserver(
  document.body,
  () => { syncScrollLock() },
  {
    childList: true,
    subtree: true,
    attributes: true,
    attributeFilter: ['data-state'],
  },
)

onUnmounted(() => {
  isLocked.value = false
})
</script>

<template>
  <DialogPortal>
    <DialogOverlay />
    <div class="fixed inset-0 z-50 flex items-center justify-center p-4 sm:p-6 md:p-8 pointer-events-none">
      <DialogContent
        data-slot="dialog-content"
        v-bind="{ ...$attrs, ...forwarded }"
        :class="
          cn(
            'bg-background data-[state=open]:animate-in data-[state=closed]:animate-out data-[state=closed]:fade-out-0 data-[state=open]:fade-in-0 data-[state=closed]:zoom-out-95 data-[state=open]:zoom-in-95 relative grid w-full gap-4 rounded-lg border p-6 shadow-lg duration-200 max-w-[90vw] sm:max-w-lg max-h-full overflow-y-auto pointer-events-auto',
            props.class,
          )"
      >
        <slot />

        <DialogClose
          v-if="showCloseButton"
          data-slot="dialog-close"
          class="absolute top-4 right-4 z-50 rounded-full bg-black/60 hover:bg-black/80 text-white p-1.5 transition-all duration-200 focus:outline-hidden border border-white/10 shadow-md flex items-center justify-center cursor-pointer [&_svg]:size-4"
        >
          <X />
          <span class="sr-only">Close</span>
        </DialogClose>
      </DialogContent>
    </div>
  </DialogPortal>
</template>
