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
    asideClass="fixed inset-0 z-30 flex-none h-full w-64 lg:h-auto lg:overflow-y-visible 
    lg:pt-20 lg:-mt-2 lg:block bg-white"
>
    <SidebarWrapper
        divClass="overflow-y-auto px-4 pt-20 lg:pt-4 h-full
        scrolling-touch max-w-2xs lg:h-[calc(100vh-4.5rem)] lg:block dark:bg-gray-800 
        lg:me-0 lg:sticky top-2"
    >
        <SidebarGroup ulClass="list-unstyled fw-normal small mb-4 space-y-2">
            <SidebarItem label="Dashboard" href="/">
                <svelte:fragment slot="icon">
                    <ChartSolid class="w-5 h-5" />
                </svelte:fragment>
            </SidebarItem>
            <SidebarDropdownWrapper label="Contenido">
                <svelte:fragment slot="icon">
                    <CartPlusAltSolid class="w-5 h-5" />
                </svelte:fragment>
                <SidebarDropdownItem label="Artículos" href="/admin/articles" />
            </SidebarDropdownWrapper>
            <SidebarDropdownWrapper label="E-commerce">
                <svelte:fragment slot="icon">
                    <ShoppingBagSolid
                        class="w-5 h-5 text-gray-500 transition duration-75 dark:text-gray-400 group-hover:text-gray-900 dark:group-hover:text-white"
                    />
                </svelte:fragment>
                <SidebarDropdownItem label="Títulos" href="/admin/titles" />
                <SidebarDropdownItem
                    label="Proveedores"
                    href="/admin/providers"
                />
                <SidebarDropdownItem label="Marcas" href="/admin/brands" />
                <SidebarDropdownItem label="Monedas" href="/admin/currencies" />
                <SidebarDropdownItem
                    label="Categorías"
                    href="/admin/categories"
                />
                <SidebarDropdownItem label="Campos" href="/admin/fields" />
                <SidebarDropdownItem label="Productos" href="/admin/products" />
            </SidebarDropdownWrapper>
            <SidebarDropdownWrapper label="Ventas">
                <svelte:fragment slot="icon">
                    <CartPlusAltSolid class="w-5 h-5" />
                </svelte:fragment>
                <SidebarDropdownItem
                    label="Cotizaciones"
                    href="/admin/quotations"
                />
                <SidebarDropdownItem label="Ordenes de venta" />
            </SidebarDropdownWrapper>
            <SidebarDropdownWrapper label="Administración">
                <svelte:fragment slot="icon">
                    <BadgeCheckSolid class="w-5 h-5" />
                </svelte:fragment>
                <SidebarDropdownItem label="Usuarios" href="/admin/users" />
                <SidebarDropdownItem label="Clientes" href="/admin/clients" />
            </SidebarDropdownWrapper>

            <SidebarDropdownWrapper label="Configuración">
                <svelte:fragment slot="icon">
                    <CogSolid class="w-5 h-5" />
                </svelte:fragment>
                <SidebarDropdownItem
                    label="Ítem de menú"
                    href="/admin/menu-items"
                />
                <SidebarDropdownItem label="Plantillas" />
            </SidebarDropdownWrapper>
            <SidebarDropdownWrapper label="Publicidad">
                <svelte:fragment slot="icon">
                    <AtomSolid class="w-5 h-5" />
                </svelte:fragment>
                <SidebarDropdownItem label="Slider" href="/admin/sliders" />
                <SidebarDropdownItem label="Banner" />
            </SidebarDropdownWrapper>

            <SidebarDropdownWrapper label="Desarrollo">
                <svelte:fragment slot="icon">
                    <AtomSolid class="w-5 h-5" />
                </svelte:fragment>
                <SidebarDropdownItem label="Sitio" href="/admin/sites" />

                <SidebarDropdownItem
                    label="Tipo de módulo"
                    href="/admin/module-types"
                />
                <SidebarDropdownItem label="Módulos" href="/admin/modules" />
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
