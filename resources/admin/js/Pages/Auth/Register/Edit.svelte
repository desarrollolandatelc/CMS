<script>
    import { Button, Heading } from "flowbite-svelte";
    import { useForm } from "@inertiajs/svelte";
    import AuthenticatedLayout from "../../../Layouts/AuthenticatedLayout.svelte";
    import Inputs from "./Partials/Inputs.svelte";

    export let user;
    const form = useForm({
        name: user.name,
        email: user.email,
        status: user.status,
        role: user.role,
        client: user.client,
    });
    const submit = () => {
        $form.put(route("users.update", user.id));
    };
</script>

<AuthenticatedLayout>
    {JSON.stringify($form)}
    <Heading tag="h4" class="mb-4">Actualizar usuario</Heading>
    <form class="w-full" on:submit|preventDefault={submit}>
        <Inputs {form}></Inputs>
        <div class="flex items-center space-x-2 mt-4">
            <Button type="submit">Actualizar</Button>
            <Button color="alternative" href="/admin/users">Cancelar</Button>
        </div>
    </form>
</AuthenticatedLayout>
