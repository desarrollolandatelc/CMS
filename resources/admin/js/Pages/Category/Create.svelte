<script>
    import { Heading, Toast } from "flowbite-svelte";
    import AuthenticatedLayout from "../../Layouts/AuthenticatedLayout.svelte";
    import Inputs from "./Partials/Inputs.svelte";
    import { useForm } from "@inertiajs/svelte";
    import { toasts, ToastContainer, FlatToast } from "svelte-toasts";

    const form = useForm({
        name: "",
        alias: "",
        status: false,
        parent_id: null,
        parent: {
            id: null,
            name: "",
        },
    });

    const submit = () => {
        $form.post(route("categories.store"), {
            onSuccess: () => {
                $form.reset();
                toasts.success({
                    description: "Categoría creada con éxito",
                });
            },
        });
    };
</script>

<AuthenticatedLayout>
    <Heading tag="h3" class="mb-4">Registrar categoría</Heading>
    <form on:submit|preventDefault={submit}>
        <Inputs {form}></Inputs>
    </form>

    <ToastContainer placement="bottom-right" let:data>
        <FlatToast {data} />
    </ToastContainer>
</AuthenticatedLayout>
