<template>
  <CModal
    alignment="center"
    :visible="isVisible"
    @close="onClose"
  >
    <CModalHeader>
      <CModalTitle>{{ title }}</CModalTitle>
    </CModalHeader>
    <CModalBody>
      <slot>
        {{ message || "Are you sure?" }}
      </slot>
    </CModalBody>
    <CModalFooter>
      <CButton color="secondary" @click="onClose">Close</CButton>
      <CButton color="primary" @click="onConfirm">Confirm</CButton>
    </CModalFooter>
  </CModal>

</template>

<script setup lang="ts">
import { CButton, CModal, CModalBody, CModalFooter, CModalHeader, CModalTitle } from '@coreui/vue';
import { computed } from 'vue';

const props = defineProps({
  title: {
    type: String,
    default: "Confirm",
  },
  message: {
    type: String,
  },
  visible: {
    type: Boolean,
    default: false,
  }
});

const emit = defineEmits(['confirmed', 'closed']);

const title = computed<string>(() => {
  return props.title;
});

const message = computed<string|undefined>(() => {
  return props.message;
});

const isVisible = computed<boolean>(() => {
  return props.visible;
});

const onConfirm = () => {
  emit('confirmed');
}

const onClose = () => {
  emit('closed');
}

</script>

<style lang="sass" scoped>
</style>
