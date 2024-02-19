<script>
    import { Label } from "flowbite-svelte";
    import WindowTable from "../../../Components/Core/WindowTable.svelte";
    import InputAction from "../../../Components/Gui/InputAction.svelte";
    import TableFormat from "./TableFormat.svelte";
    import { SearchSolid } from "flowbite-svelte-icons";

    export let form;
    let defaultModal = false;

    const selected = (event) => {
        console.log(event);
        $form.module_type_id = event.detail.id;
        $form.module_type.name = event.detail.name;
        defaultModal = false;
    };
</script>

<Label for="email" class="block w-full">
    Tipo de módulo <sup class="text-red-600">*</sup>
</Label>
<InputAction value={$form.module_type?.name} bind:defaultModal>
    <SearchSolid slot="button-title" />
    <WindowTable
        COMPONENT={TableFormat}
        searchRoute="module-types.search"
        table="module_types"
        on:change={selected}
    ></WindowTable>
</InputAction>
