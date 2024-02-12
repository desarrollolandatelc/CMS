<script>
    import { Button, Heading } from "flowbite-svelte";
    import { Link, useForm } from "@inertiajs/svelte";
    import AuthenticatedLayout from "../../../Layouts/AuthenticatedLayout.svelte";
    import axios from "axios";
    import Inputs from "./Partials/Inputs.svelte";

    const form = useForm({
        name: "",
        email: "",
        status: false,
        role: "cliente",
    });
    const submit = () => {};
</script>

<AuthenticatedLayout>
    {JSON.stringify($form)}
    <Heading tag="h4" class="mb-4">Registrar usuario</Heading>
    <form class="w-full" on:submit|preventDefault={submit}>
        <Inputs {form}></Inputs>
        <div class="flex items-center mt-4">
            <Button>Registrar</Button>
        </div>
    </form>
</AuthenticatedLayout>
