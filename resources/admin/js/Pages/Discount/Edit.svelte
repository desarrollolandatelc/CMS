<script>
    import { Heading } from "flowbite-svelte";
    import AuthenticatedLayout from "../../Layouts/AuthenticatedLayout.svelte";
    import Inputs from "./Partials/Inputs.svelte";
    import { useForm } from "@inertiajs/svelte";
    import { toasts, ToastContainer, FlatToast } from "svelte-toasts";

    export let discount;

    const form = useForm({
        name: discount.name,
        alias: discount.alias,
        product_field: discount.product_field,
        product_field_value: discount.product_field_value,
        value: discount.value,
        start_date: discount.start_date,
        end_date: discount.end_date,
        status: discount.status,
    });

    const submit = () => {
        $form.put(route("discounts.update", brand.id), {
            onSuccess: () => {
                toasts.success({
                    description: "Desuento actualizado con éxito",
                });
            },
        });
    };
</script>

<AuthenticatedLayout>
    <Heading tag="h3" class="mb-4">Actualizar un descuento</Heading>
    <form on:submit|preventDefault={submit}>
        <Inputs {form}></Inputs>
    </form>
    <ToastContainer placement="bottom-right" let:data>
        <FlatToast {data} />
        <!-- Provider template for your toasts -->
    </ToastContainer>
</AuthenticatedLayout>
