<script>
    import { Label } from "flowbite-svelte";
    import WindowTable from "../../../../Components/Core/WindowTable.svelte";
    import InputAction from "../../../../Components/Gui/InputAction.svelte";
    import { client_id } from "../helper";
    import { SearchSolid } from "flowbite-svelte-icons";
    import TableFormat from "../TableFormat.svelte";
    import { page } from "@inertiajs/svelte";
    export let form;
    let defaultModal = false;

    const selected = (event) => {
        console.log(event);
        $form.client_id = event.detail.id;
        $form.client.name = event.detail.name;
        $client_id = event.detail.id;

        defaultModal = false;
    };
</script>

<Label for="client" class="block w-full">
    Cliente <sup class="text-red-600">*</sup>
</Label>
{#if !$page.props.auth.client && !$form.client?.name}
    <InputAction value={$form.client?.name} bind:defaultModal>
        <SearchSolid slot="button-title" />
        <WindowTable
            COMPONENT={TableFormat}
            searchRoute="clients.search"
            table="clients"
            on:change={selected}
        ></WindowTable>
    </InputAction>
{:else}
    <span>{$form.client?.name}</span>
{/if}
