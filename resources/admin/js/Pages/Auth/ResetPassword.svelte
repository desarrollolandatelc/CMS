<script>
    import { Button, Input, Label, Heading, Helper } from "flowbite-svelte";
    import GuestLayout from "../../Layouts/GuestLayout.svelte";
    import { useForm, page } from "@inertiajs/svelte";

    export let email;
    export let token;

    const form = useForm({
        token: token,
        email: email,
        password: "",
        password_confirmation: "",
    });

    const submit = () => {
        $form.post(route("password.store"), {
            onFinish: () => $form.reset("password", "password_confirmation"),
        });
    };
</script>

<GuestLayout>
    <Heading tag="h4" class="mb-4">Restablecer contraseña</Heading>
    {#if $page.props.errors}
        {#each Object.values($page.props.errors) as error}
            <Helper class="my-2" color="red">{error}</Helper>
        {/each}
    {/if}
    <form on:submit|preventDefault={submit}>
        <div>
            <Label for="email">
                Correo electrónico <sup class="text-red-600">*</sup>
            </Label>
            <Input
                id="email"
                type="email"
                class="mt-1 block w-full"
                bind:value={$form.email}
                required
                autofocus
                autocomplete="username"
            />
            {#if $form.errors.email}
                <Helper class="mt-2" color="red">{$form.errors.email}</Helper>
            {/if}
        </div>

        <div class="mt-4">
            <Label for="password">
                Contraseña <sup class="text-red-600">*</sup>
            </Label>

            <Input
                id="password"
                type="password"
                class="mt-1 block w-full"
                bind:value={$form.password}
                required
                autocomplete="new-password"
            />

            {#if $form.errors.password}
                <Helper class="mt-2" color="red">{$form.errors.password}</Helper
                >
            {/if}
        </div>

        <div class="mt-4">
            <Label for="password_confirmation">
                Confirmar contraseña <sup class="text-red-600">*</sup>
            </Label>

            <Input
                id="password_confirmation"
                type="password"
                class="mt-1 block w-full"
                bind:value={$form.password_confirmation}
                required
                autocomplete="new-password"
            />

            {#if $form.errors.password_confirmation}
                <Helper class="mt-2" color="red">
                    {$form.errors.password_confirmation}
                </Helper>
            {/if}
        </div>

        <div class="flex items-center justify-end mt-4">
            <Button type="submit" color="red">Reestablecer constraseña</Button>
        </div>
    </form>
</GuestLayout>
