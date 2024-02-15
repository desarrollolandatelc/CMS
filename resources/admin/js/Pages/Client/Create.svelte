<script>
    import { Heading, Toast } from "flowbite-svelte";
    import AuthenticatedLayout from "../../Layouts/AuthenticatedLayout.svelte";
    import Inputs from "./Partials/Inputs.svelte";
    import { useForm } from "@inertiajs/svelte";
    import { toasts, ToastContainer, FlatToast } from "svelte-toasts";

    const form = useForm({
        name: "",
        email: "",
        phone: "",
        address: "",
        status: false,
        document_type_id: "",
        person_type_id: "",
        document_number: "",
        alias: "",
        discounts: [
            {
                provider: {
                    id: 0,
                    name: "",
                },
                percentage: "",
            },
        ],
    });

    const submit = () => {
        $form.post(route("clients.store"), {
            onSuccess: () => {
                $form.reset();
                toasts.success({
                    description: "Cliente creado con éxito",
                });
            },
        });
    };
</script>

<AuthenticatedLayout>
    <Heading tag="h3" class="mb-4">Registrar cliente</Heading>
    <form on:submit|preventDefault={submit}>
        <Inputs {form}></Inputs>
    </form>

    <ToastContainer placement="bottom-right" let:data>
        <FlatToast {data} />
    </ToastContainer>
</AuthenticatedLayout>
