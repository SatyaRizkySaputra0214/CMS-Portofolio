<script setup lang="ts">
import type { DialogContentEmits, DialogContentProps } from "reka-ui"
import type { HTMLAttributes } from "vue"
import { X } from "@lucide/vue"
import { reactiveOmit, useScrollLock, useMutationObserver } from "@vueuse/core"
import { onMounted, onUnmounted } from "vue"
import {
  DialogClose,
  DialogContent,
  DialogOverlay,
  DialogPortal,
  useForwardPropsEmits,
} from "reka-ui"
import { cn } from "@/lib/utils"

defineOptions({
  inheritAttrs: false,
})

const props = defineProps<DialogContentProps & { class?: HTMLAttributes["class"] }>()
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
    <DialogOverlay
      class="fixed inset-0 z-50 grid place-items-center overflow-y-auto bg-black/70 data-[state=open]:animate-in data-[state=closed]:animate-out data-[state=closed]:fade-out-0 data-[state=open]:fade-in-0"
    >
      <DialogContent
        :class="
          cn(
            'relative z-50 grid w-full max-w-[90vw] max-h-[90vh] my-8 gap-4 border border-border bg-background p-6 shadow-lg duration-200 sm:rounded-lg md:w-full',
            props.class,
          )
        "
        v-bind="{ ...$attrs, ...forwarded }"
        @pointer-down-outside="(event) => {
          const originalEvent = event.detail.originalEvent;
          const target = originalEvent.target as HTMLElement;
          if (originalEvent.offsetX > target.clientWidth || originalEvent.offsetY > target.clientHeight) {
            event.preventDefault();
          }
        }"
      >
        <slot />

        <DialogClose
          class="absolute top-4 right-4 z-50 rounded-full bg-black/60 hover:bg-black/80 text-white p-1.5 transition-all duration-200 focus:outline-hidden border border-white/10 shadow-md flex items-center justify-center cursor-pointer [&_svg]:size-4"
        >
          <X />
          <span class="sr-only">Close</span>
        </DialogClose>
      </DialogContent>
    </DialogOverlay>
  </DialogPortal>
</template>
