<script lang="ts">
    import { Button } from "flowbite-svelte";
    import { TrashBinSolid } from "flowbite-svelte-icons";
    import type { ComponentType } from "svelte";

    export let values: any[] = [];
    export let COMPONENT: ComponentType = null;
    export let hasDeletedButton = true;
    export let hasAddItemButton = true;

    const addItem = () => {
        values.push({});
        values = values;
    };

    const removeItem = (index) => {
        values.splice(index, 1);
        values = values;
    };
</script>

<div class="p-2 mt-4 grid gap-4">
    {#each values as item, index}
        <div
            class="p-4 shadow-sm border border-dashed bg-gray-50
            border-gray-300 rounded-md"
        >
            {#if hasDeletedButton}
                <div class="flex justify-end">
                    <Button
                        type="button"
                        color="red"
                        size="xs"
                        on:click={() => removeItem(index)}
                    >
                        <TrashBinSolid />
                    </Button>
                </div>
            {/if}
            <svelte:component this={COMPONENT} bind:detail={item} />
        </div>
    {/each}

    {#if hasAddItemButton}
        <div class="mt-4 w-full flex justify-center">
            <Button color="green" type="button" on:click={addItem}>
                Agregar a la lista
            </Button>
        </div>
    {/if}
</div>
