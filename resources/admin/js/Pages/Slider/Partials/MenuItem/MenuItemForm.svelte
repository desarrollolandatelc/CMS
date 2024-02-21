<script>
    import { Label } from "flowbite-svelte";
    import WindowTable from "../../../../Components/Core/WindowTable.svelte";
    import InputAction from "../../../../Components/Gui/InputAction.svelte";
    import Table from "../../../../Components/Gui/Table.svelte";
    import TableFormat from "./TableFormat.svelte";
    import { SearchSolid } from "flowbite-svelte-icons";

    export let value = {};
    let defaultModal = false;

    const selected = (event) => {
        console.log(event);
        value = {
            name: event.detail.name,
            href: event.detail.href,
        };
        defaultModal = false;
    };
</script>

<Label for="email" class="block w-full">
    Ítem de menú
</Label>
<InputAction value={value?.name} bind:defaultModal>
    <SearchSolid slot="button-title" />

    <WindowTable
        COMPONENT={TableFormat}
        searchRoute="menu-items.search"
        table="menu_items"
        on:change={selected}
    ></WindowTable>
</InputAction>
