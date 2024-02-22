<script>
    import Table from "../../../Components/Gui/Table.svelte";
    import ModalBodyTableCells from "../../../Components/Core/ModalBodyTableCells.svelte";
    export let data;
</script>

<Table
    {data}
    headerLabel={["Nombre", "Estado"]}
    BODY_FORMAT_TABLE={ModalBodyTableCells}
    hasBulkAction={false}
    on:change
></Table>