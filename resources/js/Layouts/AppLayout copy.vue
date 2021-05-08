<template>
   
    	<!--Sidebar with Dimmer -->
		<div class="fixed inset-0 flex z-40">
			<!-- Sidebar -->
			<div
				class="absolute flex top-0 h-screen z-20"
				:class="[right ? 'right-0 flex-row' : 'left-0 flex-row-reverse']"
			>
				<!--Drawer -->
				<button
					@click.prevent="toggle()"
					class="w-12 h-48 p-1 my-auto rounded text-white bg-gray-600 text-center focus:outline-none hover:bg-gray-500 transition-color duration-300"
				>
					<span
						:class="[right ? '-rotate-90' : 'rotate-90']"
						class="block transform origin-center font-bold"
					>
						Drawer
					</span>
				</button>

				<!-- Sidebar Content -->
				<div
					ref="content"
					class="transition-all duration-700 bg-yellow-200 overflow-hidden flex items-center justify-center"
					:class="[open ? 'max-w-lg' : 'max-w-0']"
				>
                    <nav class="h-screen flex flex-col w-64 bg-gray-50">
                        <div class="p-4">
                            <img src="https://tailwindcomponents.com/svg/logo-color.svg" />
                        </div>
                        <ul class="p-2 space-y-2 flex-1 overflow-auto" style="scrollbar-width: thin;">
                            <li>
                                <a href="#" class="flex space-x-2 items-center text-gray-600 p-2 bg-gray-200 rounded-lg">
                                    <span class="text-gray-900">Dashboard</span>
                                </a>
                            </li>
                        </ul>
                    </nav>
				</div>
			</div>

			<transition name="fade">
				<!-- Dimmer -->
				<div
					v-if="dimmer && open"
					@click="toggle()"
					class="flex-1 bg-gray-400 bg-opacity-75 active:outline-none z-10"
				/>
			</transition>
		</div>



</template>

<script>
    import JetApplicationMark from '@/Jetstream/ApplicationMark'
    import JetBanner from '@/Jetstream/Banner'
    import JetDropdown from '@/Jetstream/Dropdown'
    import JetDropdownLink from '@/Jetstream/DropdownLink'
    import JetNavLink from '@/Jetstream/NavLink'
    import JetResponsiveNavLink from '@/Jetstream/ResponsiveNavLink'

    export default {
        components: {
            JetApplicationMark,
            JetBanner,
            JetDropdown,
            JetDropdownLink,
            JetNavLink,
            JetResponsiveNavLink,
        },

        data() {
            return {
                showingNavigationDropdown: false,
            }
        },

        methods: {
            switchToTeam(team) {
                this.$inertia.put(route('current-team.update'), {
                    'team_id': team.id
                }, {
                    preserveState: false
                })
            },

            logout() {
                this.$inertia.post(route('logout'));
            },
        }
    }
</script>
