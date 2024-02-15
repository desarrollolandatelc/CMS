<script>
    import { DropdownItem } from "flowbite-svelte";
    import BulkActionsButton from "./BulkActionsButton.svelte";
    import { TrashBinSolid } from "flowbite-svelte-icons";
    import { router } from "@inertiajs/svelte";
    import { toasts, ToastContainer, FlatToast } from "svelte-toasts";

    export let selected;
    export let selectedAll = false;

    export let url;
    const deleteSelected = () => {
        const confirm = window.confirm(
            "¿Desea eliminar los registros seleccionados?",
        );
        if (!confirm) {
            return;
        }
        router.post(
            url,
            {
                ids: selected,
                _method: "DELETE",
            },
            {
                onSuccess: () => {
                    selected = [];
                    toasts.success({
                        description:
                            "Se han eliminado los registros seleccionados",
                    });
                    selectedAll = false;
                },
            },
        );
    };
</script>

<BulkActionsButton>
    <DropdownItem
        class="flex text-red-600 dark:text-red-400"
        on:click={deleteSelected}
    >
        <TrashBinSolid />Eliminar seleccionados
    </DropdownItem>
</BulkActionsButton>

<ToastContainer placement="bottom-right" let:data>
    <FlatToast {data} />
</ToastContainer>
