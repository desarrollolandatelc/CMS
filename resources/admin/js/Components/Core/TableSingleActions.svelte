<script>
    import DeleteAction from "./DeleteAction.svelte";

    export let editRoute = "";
    export let deleteRoute = "";
    export let item;

    const route = window.route;

</script>

<a
    href={route(editRoute, item.id)}
    class="font-medium text-primary-600 hover:underline dark:text-primary-500"
>
    Editar
</a>
<DeleteAction url={route(deleteRoute, item.id)} />
