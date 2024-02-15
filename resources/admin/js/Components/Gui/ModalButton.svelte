<script lang="ts">
    import { Button, Modal } from "flowbite-svelte";

    import type { ComponentType } from "svelte";
    export let title: string = "";

    export let defaultModal: boolean = false;
    export let COMPONENT: ComponentType = null;
    export let modalTitle: string = "";
</script>

<button
    type="button"
    class="rounded-r-md border-r border-t border-b p-2 bg-gray-200"
    on:click={() => (defaultModal = true)}
>
    {title}
</button>

<Modal title={modalTitle} bind:open={defaultModal}>
    <svelte:component this={COMPONENT} on:change />
</Modal>
