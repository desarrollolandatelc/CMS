<script>
    import { Button, Dropdown, DropdownItem } from "flowbite-svelte";
    import { ChevronDownSolid } from "flowbite-svelte-icons";
</script>

<Button color="light">
    Acciones masivas
    <ChevronDownSolid class="w-3 h-3 ms-2 text-gray-600 dark:text-white" />
</Button>
<Dropdown>
    <slot />
</Dropdown>
