<template>
    <ConfirmationModal :show="state.show">

    <template #title>
        {{ state.title}}
    </template>

    <template #content>
        {{ state.message }}
    </template>

    <template #footer>
        <SecondaryButton ref="cancelButtonRef" @click="cancel">Cancel</SecondaryButton>
        <PrimaryButton @click="confirm" class="ml-3">Confirm</PrimaryButton>
    </template>
        
    </ConfirmationModal>
</template>

<script setup>
import { watchEffect } from 'vue';
import ConfirmationModal from './ConfirmationModal.vue';
import PrimaryButton from './PrimaryButton.vue';
import SecondaryButton from './SecondaryButton.vue';
import { nextTick, ref } from 'vue';
import { useConfirm } from '/resources/js/Utilities/Composables/useCofirm.js';

const { state, confirm, cancel } = useConfirm()

const cancelButtonRef = ref(null);

watchEffect(async () => { 
    if (state.show) {
        await nextTick();
        cancelButtonRef.value?.$el.focus();

        const confirmButton = document.querySelector('.primary-button');
        if (confirmButton) {
           
        }
    }
})
</script>