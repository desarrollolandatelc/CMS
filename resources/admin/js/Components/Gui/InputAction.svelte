<script lang="ts">
    import { Input } from "flowbite-svelte";
    import ModalButton from "./ModalButton.svelte";

    import type { ComponentType } from "svelte";

    export let value: { id: number; name: string } = { id: 0, name: "" };
    export let COMPONENT: ComponentType = null;

    let defaultModal: boolean = false;

    const selected = (event) => {
        defaultModal = false;
        value = {
            id: event.detail.id,
            name: event.detail.name,
        };
    };
</script>

<div class="flex">
    <Input
        type="text"
        class="border-l border-t border-b rounded-l-md rounded-r-none"
        disabled
        value={value?.name}
        required
    />
    <ModalButton
        title="Buscar"
        modalTitle="Buscar"
        bind:defaultModal
        {COMPONENT}
        on:change={selected}
    />
</div>
