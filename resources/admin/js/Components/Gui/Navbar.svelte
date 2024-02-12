<script>
    import {
        Button,
        DarkMode,
        NavBrand,
        NavHamburger,
        NavLi,
        NavUl,
        Navbar,
        Search,
        ToolbarButton,
        Input,
    } from "flowbite-svelte";

    import { BellSolid, SearchOutline } from "flowbite-svelte-icons";
</script>

<Navbar fluid color="default">
    <NavHamburger id="nav-hamburger" />

    <NavBrand href="/">
        <span
            class="self-center whitespace-nowrap text-xl font-semibold dark:text-white"
        >
            Administración
        </span>
    </NavBrand>

    <div class="ms-auto flex items-center gap-2 p-1">
        <ToolbarButton size="lg"><BellSolid /></ToolbarButton>
    </div>
</Navbar>
