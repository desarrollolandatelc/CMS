<script>
    import axios from "axios";
    import { onMount } from "svelte";
    //Obtenemos todos los ítems del módulo menú principal

    export let menuItems = [];

    const searchMenuItems = () => {
        axios
            .get(
                route("menu-items.get-all-by-module-alias", {
                    alias: "Menu-principal",
                }),
            )
            .then((response) => (menuItems = response.data));
    };

    onMount(() => {
        searchMenuItems();
    });
</script>

<ul class="navbar-nav mr-auto main-nav-left">
    {#each menuItems as item}
        <li class="nav-item" class:dropdown={item.childrens.length > 0}>
            <a
                class="nav-link"
                class:dropdown-toggle={item.childrens.length > 0}
                href="{item.href}"
                >{item.name}
            </a>
            {#if item.childrens.length > 0}
                <div
                    class="dropdown-menu dropdown-menu-right shadow-sm border-0"
                >
                    {#each item.childrens as child}
                        <a class="dropdown-item" href={child.href}
                            >{child.name}</a
                        >
                    {/each}
                </div>
            {/if}
        </li>
    {/each}
</ul>
