<script>
    import Navbar from "../Components/Gui/Navbar.svelte";
    import Sidebar from "../Components/Gui/Sidebar.svelte";
</script>

<header
    class="sticky top-0 z-40 mx-auto w-full flex-none border-b border-gray-200 bg-white dark:border-gray-600 dark:bg-gray-800"
>
    <Navbar></Navbar>
</header>
<div class="overflow-hidden lg:flex">
    <Sidebar></Sidebar>
    <main class="relative h-full w-full overflow-y-auto lg:ml-64">
        <div class="px-4 pt-6">
            <!-- Page Content -->
            <slot />
        </div>
    </main>
</div>
