<script>
    import { Label } from "flowbite-svelte";
    import WindowTable from "../../../../Components/Core/WindowTable.svelte";
    import InputAction from "../../../../Components/Gui/InputAction.svelte";
    import Table from "../../../../Components/Gui/Table.svelte";
    import TableFormat from "../TableFormat.svelte";
    import { SearchSolid } from "flowbite-svelte-icons";

    export let form;
    let defaultModal = false;

    const selected = (event) => {
        console.log(event);
        $form.title_id = event.detail.id;
        $form.title.name = event.detail.name;
        defaultModal = false;
    };
</script>

<Label for="email" class="block w-full">
    Nombre <sup class="text-red-600">*</sup>
</Label>
<InputAction value={$form.title?.name} bind:defaultModal>
    <SearchSolid slot="button-title" />

    <WindowTable
        COMPONENT={TableFormat}
        searchRoute="titles.search"
        table="titles"
        on:change={selected}
    ></WindowTable>
</InputAction>
