<script>
    import { Heading } from "flowbite-svelte";
    import AuthenticatedLayout from "../../Layouts/AuthenticatedLayout.svelte";
    import Inputs from "./Partials/Inputs.svelte";
    import { useForm } from "@inertiajs/svelte";
    import { toasts, ToastContainer, FlatToast } from "svelte-toasts";

    const form = useForm({
        user_id: "",
        client_id: "",
        status: "pending",
        details: [],
        user: {
            id: "",
            name: "",
        },
        client: {
            id: "",
            name: "",
        },
    });

    const submit = () => {
        $form.post(route("quotations.store"), {
            onSuccess: () => {
                $form.reset();
                toasts.success({
                    description: "Cotización creada con éxito",
                });
            },
        });
    };
</script>

<AuthenticatedLayout>
    <Heading tag="h3" class="mb-4">Registrar cotización</Heading>
    <form on:submit|preventDefault={submit}>
        <Inputs {form}></Inputs>
    </form>

    <ToastContainer placement="bottom-right" let:data>
        <FlatToast {data} />
    </ToastContainer>
</AuthenticatedLayout>
