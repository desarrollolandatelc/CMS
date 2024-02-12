<script>
    import { Button, Helper, Input, Label, Heading } from "flowbite-svelte";
    import GuestLayout from "../../Layouts/GuestLayout.svelte";
    import { useForm } from "@inertiajs/svelte";

    const form = useForm({
        email: "",
    });

    const submit = () => {
        console.log("submit");
        $form.post(route("password.email"));
    };
</script>

<GuestLayout>
    <Heading tag="h4" class="mb-4">¿Olvidó la contraseña?</Heading>

    <div class="mb-4 text-sm text-gray-600">
        Si olvistaste la contraseña no te preocupes. Solo tienes que introducir
        tu correo electronico y te enviaremos un enlace para restablecer tu
        contraseña.
    </div>

    <form on:submit|preventDefault={submit}>
        <div>
            <Label for="email" class="block mb-2">
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
                <Helper class="mt-2" color="red">
                    {$form.errors.email}
                </Helper>
            {/if}
        </div>

        <div class="flex items-center justify-end mt-4">
            <Button type="submit" color="red">Reestablecer constraseña</Button>
        </div>
    </form>
</GuestLayout>
