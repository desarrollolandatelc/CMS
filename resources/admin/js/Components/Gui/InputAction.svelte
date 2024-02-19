<script lang="ts">
    import { Input } from "flowbite-svelte";
    import ModalButton from "./ModalButton.svelte";

    export let value: string = "";
    export let modalTitle: string = "Buscar";

    export let defaultModal: boolean = false;
</script>

<div class="flex mt-1">
    <Input
        type="text"
        class="border-l border-t border-b rounded-l-md rounded-r-none"
        disabled
        bind:value
        required
    />
    <ModalButton
        class="rounded-r-md border-r border-t border-b"
        {modalTitle}
        bind:defaultModal
    >
        <slot name="button-title" slot="button-title" />
        <slot />
    </ModalButton>
</div>
