<script>
    import { Label } from "flowbite-svelte";
    import WindowTable from "../../../Components/Core/WindowTable.svelte";
    import InputAction from "../../../Components/Gui/InputAction.svelte";
    import Table from "../../../Components/Gui/Table.svelte";

    export let form;
    let defaultModal = false;

    const selected = (event) => {
        console.log(event);
        $form.brand_id = event.detail.id;
        $form.brand.name = event.detail.name;
        defaultModal = false;
    };
</script>

<Label for="email" class="block w-full">
    Marca <sup class="text-red-600">*</sup>
</Label>
<InputAction value={$form.brand?.name} bind:defaultModal>
    <WindowTable
        COMPONENT={Table}
        searchRoute="brands.search"
        table="brands"
        on:change={selected}
    ></WindowTable>
</InputAction>
