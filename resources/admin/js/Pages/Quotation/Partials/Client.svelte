<script>
    import { Label } from "flowbite-svelte";
    import WindowTable from "../../../Components/Core/WindowTable.svelte";
    import InputAction from "../../../Components/Gui/InputAction.svelte";
    import Table from "../../../Components/Gui/Table.svelte";
    import { client_id } from "./helper";

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
    Customer <sup class="text-red-600">*</sup>
</Label>
<InputAction value={$form.client?.name} bind:defaultModal>
    <WindowTable
        COMPONENT={Table}
        searchRoute="clients.search"
        table="clients"
        on:change={selected}
    ></WindowTable>
</InputAction>
