<script lang="ts">
    import { Pagination, PaginationItem } from "flowbite-svelte";

    export let paginate: Paginate;
</script>

{#if paginate.data.length > 0}
    <div class="flex flex-col items-center justify-center gap-2 mt-4">
        <div class="text-sm text-gray-700 dark:text-gray-400">
            Mostrando del <span
                class="font-semibold text-gray-900 dark:text-white"
            >
                {paginate.from}
            </span>
            al
            <span class="font-semibold text-gray-900 dark:text-white">
                {paginate.to}
            </span>
            de
            <span class="font-semibold text-gray-900 dark:text-white">
                {paginate.total}
            </span>
            Entradas
        </div>

        <Pagination>
            {#each paginate.links as link}
                <PaginationItem
                    href={link.url}
                    active={link.active}
                    disabled={link.url === null}
                    on:click
                    on:keydown
                >
                    {link.label}
                </PaginationItem>
            {/each}
        </Pagination>
    </div>
{/if}
