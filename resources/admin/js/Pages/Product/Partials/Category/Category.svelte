<script>
    import { Label } from "flowbite-svelte";
    import WindowTable from "../../../../Components/Core/WindowTable.svelte";
    import InputAction from "../../../../Components/Gui/InputAction.svelte";
    import { SearchSolid } from "flowbite-svelte-icons";
    import TableFormat from "../TableFormat.svelte";

    export let form;
    let defaultModal = false;

    const selected = (event) => {
        console.log(event);
        $form.category_id = event.detail.id;
        $form.category.name = event.detail.name;
        defaultModal = false;
    };
</script>

<Label for="email" class="block w-full">
    Categoría <sup class="text-red-600">*</sup>
</Label>
<InputAction value={$form.category?.name} bind:defaultModal>
    <SearchSolid slot="button-title" />

    <WindowTable
        COMPONENT={TableFormat}
        searchRoute="categories.search"
        table="categories"
        on:change={selected}
    ></WindowTable>
</InputAction>
