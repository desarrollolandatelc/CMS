<script>
    import { DropdownItem, Helper, Radio } from "flowbite-svelte";
    import BulkActionsButton from "../../../Components/Gui/BulkActionsButton.svelte";
    import { TrashBinSolid } from "flowbite-svelte-icons";
    import { router } from "@inertiajs/svelte";
    import { toasts, ToastContainer, FlatToast } from "svelte-toasts";

    export let selected;
    export let selectedAll = false;
    const deleteSelected = () => {
        const confirm = window.confirm(
            "¿Desea eliminar los clientes seleccionados?",
        );
        if (!confirm) {
            return;
        }
        router.post(
            route("clients.bulk-destroy"),
            {
                ids: selected,
                _method: "DELETE",
            },
            {
                onSuccess: () => {
                    selected = [];
                    toasts.success({
                        description:
                            "Se han eliminado los clientes seleccionados",
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
