<script>
    import { Heading } from "flowbite-svelte";
    import AuthenticatedLayout from "../../Layouts/AuthenticatedLayout.svelte";
    import Inputs from "./Partials/Inputs.svelte";
    import { useForm } from "@inertiajs/svelte";
    import { toasts, ToastContainer, FlatToast } from "svelte-toasts";

    export let menuItem;

    const form = useForm({
        name: menuItem.name,
        alias: menuItem.alias,
        href: menuItem.href,
        status: menuItem.status,
        module_id: menuItem.module_id,
    });

    const submit = () => {
        $form.put(route("menu-items.update", menuItem.id), {
            onSuccess: () => {
                toasts.success({
                    description: "Ítem de menú actualizado con éxito",
                });
            },
        });
    };
</script>

<AuthenticatedLayout>
    <Heading tag="h3" class="mb-4">Actualizar ítem de menú</Heading>
    <form on:submit|preventDefault={submit}>
        <Inputs {form}></Inputs>
    </form>
    <ToastContainer placement="bottom-right" let:data>
        <FlatToast {data} />
        <!-- Provider template for your toasts -->
    </ToastContainer>
</AuthenticatedLayout>
