<script>
    import Table from "../../../../Components/Gui/Table.svelte";
    import ModalBodyTableCells from "../../../Product/Partials/ModalBodyTableCells.svelte";
    export let data;
</script>

<Table
    {data}
    headerLabel={["Cód barras", "Nombre", "Precio"]}
    BODY_FORMAT_TABLE={ModalBodyTableCells}
    hasBulkAction={false}
    on:change
></Table>