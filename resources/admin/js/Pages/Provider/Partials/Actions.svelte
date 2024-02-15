<script>
    import DeleteAction from "../../../Components/Core/DeleteAction.svelte";
    import { toasts, ToastContainer, FlatToast } from "svelte-toasts";

    export let data;
</script>

<a
    href="/admin/providers/{data.id}/edit"
    class="font-medium text-primary-600 hover:underline dark:text-primary-500"
>
    Editar
</a>
<DeleteAction url={route("providers.destroy", data.id)}>Eliminar</DeleteAction>
<ToastContainer placement="bottom-right" let:data>
    <FlatToast {data} />
</ToastContainer>
