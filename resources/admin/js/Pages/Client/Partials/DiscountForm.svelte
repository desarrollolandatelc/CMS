<script lang="ts">
    import { Input, Label } from "flowbite-svelte";
    import InputAction from "../../../Components/Gui/InputAction.svelte";
    import ProviderTable from "./ProviderTable.svelte";

    export let detail: {
        provider: { id: number; name: string };
        percentage: number;
    } = {
        provider: {
            id: 0,
            name: "",
        },
        percentage: 0,
    };
</script>

<div class="grid md:grid-cols-2 gap-4 mt-4">
    <div>
        <Label>Proveedor</Label>
        <InputAction COMPONENT={ProviderTable} bind:value={detail.provider}
        ></InputAction>
    </div>
    <div>
        <Label>Porcentaje</Label>
        <Input
            placeholder="Porcentaje %"
            type="number"
            bind:value={detail.percentage}
        />
    </div>
</div>
