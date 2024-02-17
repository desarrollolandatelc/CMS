<script>
    import { Label } from "flowbite-svelte";
    import WindowTable from "../../../../Components/Core/WindowTable.svelte";
    import InputAction from "../../../../Components/Gui/InputAction.svelte";
    import { client_id } from "../helper";
    import { SearchSolid } from "flowbite-svelte-icons";
    import TableFormat from "../TableFormat.svelte";

    export let form;
    let defaultModal = false;

    const selected = (event) => {
        $form.client_id = event.detail.id;
        $form.client.name = event.detail.name;
        $client_id = event.detail.id;

        defaultModal = false;
    };
</script>

<Label for="client" class="block w-full">
    Vendedor <sup class="text-red-600">*</sup>
</Label>
<InputAction value={$form.user?.name} bind:defaultModal>
    <SearchSolid slot="button-title" />
    <WindowTable
        COMPONENT={TableFormat}
        searchRoute="users.search"
        table="users"
        on:change={selected}
    ></WindowTable>
</InputAction>
