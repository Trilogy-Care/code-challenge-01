<template>
  <div class="bg-gray-100 h-screen">
    <header class="bg-white">
      <div class="container mx-auto p-6">
        <h1 class="font-semibold text-xl text-black text-center">
          <slot name="header"></slot>
        </h1>
      </div>
    </header>

    <main class="container mx-auto bg-gray-100 p-16">
      <slot name="body"></slot>
    </main>

    <footer class="container mx-auto text-gray-800 py-4 px-16">
      &copy; {{ new Date().getFullYear() }} Trilogy Care
    </footer>
  </div>
</template>