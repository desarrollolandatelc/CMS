<script>
    import PrincipalMenu from "../../Components/PrincipalMenu.svelte";
</script>

<div class="main-nav shadow-sm">
    <nav class="navbar navbar-expand-lg navbar-light bg-white pt-0 pb-0">
        <div class="container">
            <a class="navbar-brand" href="index.html">
                <!--Logo-->
                Logo
            </a>
            <button
                class="navbar-toggler"
                type="button"
                data-toggle="collapse"
                data-target="#navbarSupportedContent"
                aria-controls="navbarSupportedContent"
                aria-expanded="false"
                aria-label="Toggle navigation"
            >
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <PrincipalMenu />

                <form class="form-inline my-2 my-lg-0 top-search">
                    <button class="btn-link" type="submit">
                        <i class="icofont-search"></i>
                    </button>
                    <input
                        class="form-control mr-sm-2"
                        type="search"
                        placeholder="Search for products, brands and more"
                        aria-label="Search"
                    />
                </form>
                <ul class="navbar-nav ml-auto profile-nav-right">
                    <li class="nav-item cart-nav">
                        <a data-toggle="offcanvas" class="nav-link" href={"#"}>
                            <i class="icofont-basket"></i>
                            Cart
                            <span class="badge badge-danger">5</span>
                        </a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>
</div>
