<script>
    import ModalBodyTableCells from "../../../../Components/Core/ModalBodyTableCells.svelte";
    import Table from "../../../../Components/Gui/Table.svelte";
    export let data;
</script>

<Table
    {data}
    BODY_FORMAT_TABLE={ModalBodyTableCells}
    hasBulkAction={false}
    on:change
></Table>