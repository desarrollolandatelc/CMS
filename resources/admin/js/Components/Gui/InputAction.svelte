<script lang="ts">
    import { Input } from "flowbite-svelte";
    import ModalButton from "./ModalButton.svelte";

    export let value: string = "";

    export let defaultModal: boolean = false;
</script>

<div class="flex">
    <Input
        type="text"
        class="border-l border-t border-b rounded-l-md rounded-r-none"
        disabled
        bind:value
        required
    />
    <ModalButton title="Buscar" modalTitle="Buscar" bind:defaultModal>
        <slot />
    </ModalButton>
</div>
