<script lang="ts">
    import { Modal } from "flowbite-svelte";

    export let defaultModal: boolean = false;
    export let modalTitle: string = "";
    let className: string = "";

    export { className as class };
</script>

<button
    type="button"
    class="p-2 bg-gray-200 {className}"
    on:click={() => (defaultModal = true)}
>
    <slot name="button-title" />
</button>

<Modal title={modalTitle} bind:open={defaultModal}>
    <slot />
</Modal>
