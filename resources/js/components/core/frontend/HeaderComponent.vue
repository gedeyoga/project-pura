<template>
    <header>
        <div class="container-fluid">
            <nav class="navbar navbar-expand-lg navbar-light bg-light py-5">
                <a class="navbar-brand" :href="$url">Yoga Permana</a>
                <button
                    class="navbar-toggler bgc-primary"
                    type="button"
                    data-toggle="collapse"
                    data-target="#navbarSupportedContent"
                    aria-controls="navbarSupportedContent"
                    aria-expanded="false"
                    aria-label="Toggle navigation"
                >
                    <span class="navbar-toggler-icon"></span>
                </button>

                <div
                    class="collapse navbar-collapse pt-5 pt-lg-0"
                    id="navbarSupportedContent"
                >
                    <ul class="navbar-nav ml-auto">
                        <li class="nav-item" :class="$route.name == 'home' ? 'active' : ''">
                            <a class="nav-link" :href="$router.resolve({name: 'home'}).href">Beranda</a>
                        </li>
                        <li class="nav-item" :class="$route.name == 'category.detail.list' ? 'active' : ''">
                            <a 
                                class="nav-link" 
                                :href="$router.resolve({name: 'category.detail.list' , params:{category: 'portofolio'} }).href" 
                            >Portofolio</a>
                        </li>
                        <li class="nav-item" :class="$route.name == 'article.list' ? 'active' : ''">
                            <a class="nav-link" :href="$router.resolve({name: 'article.list'}).href">Artikel</a>
                        </li>
                        <li class="nav-item" :class="$route.name == 'tentang.list' ? 'active' : ''">
                            <a class="nav-link" href="#">Tentang</a>
                        </li>
                    </ul>
                    <a href="https://wa.me/6281236540148" class="btn button-primary btn-sm ml-lg-4">Hubungi Saya</a>
                </div>
            </nav>
        </div>
    </header>
</template>
