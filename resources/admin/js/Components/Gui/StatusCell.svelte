<script lang="ts">
    export let status: number;
</script>

<span
    class="text-white p-1 rounded-md text-xs"
    class:bg-green-500={status}
    class:bg-orange-500={!status}
>
    {status ? "Activo" : "Inactivo"}
</span>
