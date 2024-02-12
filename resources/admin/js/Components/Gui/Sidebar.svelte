<script lang="ts">
    //import { page } from "$app/stores";
    import {
        Sidebar,
        SidebarDropdownItem,
        SidebarDropdownWrapper,
        SidebarGroup,
        SidebarItem,
        SidebarWrapper,
    } from "flowbite-svelte";

    import {
        ChartSolid,
        MailBoxSolid,
        UserSolid,
        ArrowRightToBracketSolid,
        ShoppingBagSolid,
        CartPlusAltSolid,
        CogSolid,
        BadgeCheckOutline,
        BadgeCheckSolid,
        AtomSolid,
    } from "flowbite-svelte-icons";

    import { onMount, onDestroy } from "svelte";
    let drawerHidden: boolean = false;

    const closeDrawer = () => {
        drawerHidden = true;
    };
    onMount(() => {
        closeDrawer();

        document
            .getElementById("nav-hamburger")
            .addEventListener("click", () => {
                drawerHidden = !drawerHidden;
            });
    });

    onDestroy(() => {
        document
            .getElementById("nav-hamburger")
            .removeEventListener("click", () => {
                drawerHidden = !drawerHidden;
            });
    });

    /*  $: activeUrl = $page.url.pathname;
    let activeClass =
        "flex items-center p-2 text-base font-normal text-primary-900 bg-primary-200 dark:bg-primary-700 rounded-lg dark:text-white hover:bg-primary-100 dark:hover:bg-gray-700";
    let nonActiveClass =
        "flex items-center p-2 text-base font-normal text-green-900 rounded-lg dark:text-white hover:bg-green-100 dark:hover:bg-green-700"; */
</script>

<Sidebar
    class={drawerHidden ? "hidden" : ""}
    asideClass="fixed inset-0 z-30 flex-none h-full w-64 lg:h-auto 
    border-e border-gray-200 dark:border-gray-600 lg:overflow-y-visible 
    lg:pt-20 lg:-mt-2 lg:block"
>
    <SidebarWrapper
        divClass="overflow-y-auto px-4 pt-20 lg:pt-4 h-full bg-white 
        scrolling-touch max-w-2xs lg:h-[calc(100vh-4.5rem)] lg:block dark:bg-gray-800 
        lg:me-0 lg:sticky top-2"
    >
        <SidebarGroup ulClass="list-unstyled fw-normal small mb-4 space-y-2">
            <SidebarItem label="Dashboard" href="/">
                <svelte:fragment slot="icon">
                    <ChartSolid class="w-5 h-5" />
                </svelte:fragment>
            </SidebarItem>
            <SidebarDropdownWrapper label="E-commerce">
                <svelte:fragment slot="icon">
                    <ShoppingBagSolid
                        class="w-5 h-5 text-gray-500 transition duration-75 dark:text-gray-400 group-hover:text-gray-900 dark:group-hover:text-white"
                    />
                </svelte:fragment>
                <SidebarDropdownItem label="Títulos" />
                <SidebarDropdownItem label="Proveedores" />
                <SidebarDropdownItem label="Marcas" />
                <SidebarDropdownItem label="Monedas" />
                <SidebarDropdownItem label="Categorías" />
                <SidebarDropdownItem label="Campos" />
                <SidebarDropdownItem label="Productos" />
            </SidebarDropdownWrapper>
            <SidebarDropdownWrapper label="Ventas">
                <svelte:fragment slot="icon">
                    <CartPlusAltSolid class="w-5 h-5" />
                </svelte:fragment>
                <SidebarDropdownItem label="Cotizaciones" />
                <SidebarDropdownItem label="Ordenes de venta" />
            </SidebarDropdownWrapper>
            <SidebarDropdownWrapper label="Administración">
                <svelte:fragment slot="icon">
                    <BadgeCheckSolid class="w-5 h-5" />
                </svelte:fragment>
                <SidebarDropdownItem label="Usuarios" />
                <SidebarDropdownItem label="Clientes" />
            </SidebarDropdownWrapper>

            <SidebarDropdownWrapper label="Configuración">
                <svelte:fragment slot="icon">
                    <CogSolid class="w-5 h-5" />
                </svelte:fragment>
                <SidebarDropdownItem label="Sitio" />
                <SidebarDropdownItem label="Plantillas" />
            </SidebarDropdownWrapper>
            <SidebarDropdownWrapper label="Publicidad">
                <svelte:fragment slot="icon">
                    <AtomSolid class="w-5 h-5" />
                </svelte:fragment>
                <SidebarDropdownItem label="Slider" />
                <SidebarDropdownItem label="Banner" />
            </SidebarDropdownWrapper>
        </SidebarGroup>
    </SidebarWrapper>
</Sidebar>

<div
    hidden={drawerHidden}
    class="fixed inset-0 z-20 bg-gray-900/50 dark:bg-gray-900/60"
    on:click={closeDrawer}
    on:keydown={closeDrawer}
    role="presentation"
/>
