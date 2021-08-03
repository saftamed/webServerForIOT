<template>
    <app-layout>
        <!--Sidebar with Dimmer -->
        <div class="fixed inset-0 flex z-50 sd">
            <!-- Sidebar -->
            <div
                class="absolute flex top-0 h-screen z-50"
                :class="[
                    right ? 'right-0 flex-row' : 'left-0 flex-row-reverse',
                ]"
            >
                <!--Drawer -->
                <button
                    v-if="edit"
                    @click.prevent="toggle()"
                    class="
                        p-1
                        my-auto
                        rounded
                        text-white
                        bg-gray-500
                        text-center
                        focus:outline-none
                        hover:bg-gray-400
                        transition-color
                        duration-300
                    "
                >
                    <span class="block transform origin-center font-bold">
                        <i class="far fa-arrow-alt-from-left"></i>
                    </span>
                </button>

                <!-- Sidebar Content -->
                <div
                    ref="content"
                    class="
                        transition-all
                        duration-700
                        bg-yellow-200
                        overflow-hidden
                        flex
                        items-center
                        justify-center
                    "
                    :class="[open ? 'max-w-lg' : 'max-w-0']"
                >
                    <nav class="h-screen flex flex-col w-64 bg-gray-50">
                        <div class="p-4">
                            <div id="com">Components</div>
                        </div>
                        <ul
                            class="p-2 space-y-2 flex-1 overflow-auto"
                            style="scrollbar-width: thin"
                        >
                            <li @click="addRelay('D')">
                                <a
                                    href="#"
                                    class="
                                        flex
                                        space-x-2
                                        items-center
                                        text-gray-600
                                        p-2
                                        bg-gray-200
                                        rounded-lg
                                    "
                                >
                                    <span class="text-gray-900">Add Relay</span>
                                    <i class="fal fa-toggle-on"></i>
                                </a>
                            </li>
                            <li @click="addRelay('P')">
                                <a
                                    href="#"
                                    class="
                                        flex
                                        space-x-2
                                        items-center
                                        text-gray-600
                                        p-2
                                        bg-gray-200
                                        rounded-lg
                                    "
                                >
                                    <span class="text-gray-900"
                                        >Add Slider</span
                                    >
                                    <i class="fal fa-toggle-on"></i>
                                </a>
                            </li>
                            <li @click="addRelay('I')">
                                <a
                                    href="#"
                                    class="
                                        flex
                                        space-x-2
                                        items-center
                                        text-gray-600
                                        p-2
                                        bg-gray-200
                                        rounded-lg
                                    "
                                >
                                    <span class="text-gray-900"
                                        >Add Switch</span
                                    >
                                    <i class="fal fa-toggle-on"></i>
                                </a>
                            </li>
                            <li @click="addRelay('A')">
                                <a
                                    href="#"
                                    class="
                                        flex
                                        space-x-2
                                        items-center
                                        text-gray-600
                                        p-2
                                        bg-gray-200
                                        rounded-lg
                                    "
                                >
                                    <span class="text-gray-900">Add gauge</span>
                                    <i class="fal fa-toggle-on"></i>
                                </a>
                            </li>
                        </ul>
                    </nav>
                </div>
            </div>
        </div>
        <transition>
            <!-- Dimmer -->
            <div
                v-if="dimmer && open"
                @click="toggle()"
                class="
                    flex-1
                    bg-gray-400 bg-opacity-75
                    active:outline-none
                    z-10
                    sm
                "
            />
        </transition>
        <template #header>
            <button
                @click.prevent="starEdit"
                v-if="!edit"
                class="
                    bg-blue-500
                    hover:bg-blue-400
                    text-white
                    font-bold
                    py-2
                    px-4
                    border-b-4 border-blue-700
                    hover:border-blue-500
                    rounded
                "
            >
                Edit
            </button>

            <button
                @click.prevent="setting = true"
                v-if="!edit"
                class="
                    bg-blue-500
                    hover:bg-blue-400
                    text-white
                    ml-1
                    font-bold
                    py-2
                    px-4
                    border-b-4 border-blue-700
                    hover:border-blue-500
                    rounded
                "
            >
                Setting <i class="fas fa-tools"></i>
            </button>
            <button
                @click="cancel"
                v-if="edit"
                class="
                    mr-1
                    bg-blue-500
                    hover:bg-blue-700
                    text-white
                    font-bold
                    py-2
                    px-4
                    rounded-full
                "
            >
                Cancel
            </button>
            <button
                @click="save"
                v-if="edit"
                class="
                    bg-blue-500
                    hover:bg-blue-700
                    text-white
                    font-bold
                    py-2
                    px-4
                    rounded-full
                "
            >
                Save
            </button>

            <span
                v-if="connected"
                class="
                    right-3
                    text-green-800
                    absolute
                    font-bold
                    py-2
                    px-4
                    inline-flex
                    items-center
                "
            >
                <span class="mr-2">Connected </span>
                <i class="fill-current w-4 h-4 far fa-wifi"></i>
            </span>
            <span
                v-else
                class="
                    right-3
                    text-red-600
                    absolute
                    font-bold
                    py-2
                    px-4
                    inline-flex
                    items-center
                "
            >
                <span class="mr-2"> Disconnected</span>
                <i class="fill-current w-4 h-4 far fa-wifi-slash"></i>
            </span>
        </template>

        <div class="d-flex ccm" id="wrapper">
            <!-- Page Content -->
            <div id="page-content-wrapper">
                <div class="container-fluid">
                    <div id="space">
                        <div
                            class="mb-8 p-2 w-full flex flex-wrap bg-grey-light ccm"
                        >
                            <div
                                class="
                                    h-16
                                    border-8
                                    res
                                    w-full
                                    md:w-1/2
                                    lg:w-1/3
                                    bg-grey
                                    rows
                                "
                                v-for="(ss, ii) in data"
                                :key="ii"
                                v-bind:style="{ height: param[ii] + 'px' }"
                            >
                                <div
                                    class="ui-widget-content draggable"
                                    v-for="(item, i) in ss"
                                    :key="item.id"
                                    v-bind:style="{
                                        top: item.option.top + 'px',
                                        left: item.option.left + 'px',
                                        width: item.option.width + 'px',
                                        height: item.option.height + 'px',
                                    }"
                                >
                                    <div class="title1">
                                        <span>{{ item.option.name }}</span>
                                        <span id="ss" v-if="edit"
                                            ><i class="fad fa-arrows-alt"></i
                                        ></span>
                                    </div>

                                    <div class="cc ccm" v-if="item.action == 'D'">
                                        <input
                                            type="checkbox"
                                            v-bind:id="'switch' + i + ii"
                                            v-model="item.value"
                                            true-value="1"
                                            false-value="0"
                                        />
                                        <label
                                            @click="switchChange($event, ii, i)"
                                            v-bind:for="'switch' + i + ii"
                                            class="switch"
                                            :style="{
                                                background:
                                                    item.value == 1
                                                        ? item.option.color
                                                        : 'gray',
                                            }"
                                        >
                                            <div
                                                :class="
                                                    item.value == 1
                                                        ? 'pr-7'
                                                        : 'pl-10'
                                                "
                                            >
                                                {{
                                                    item.value == 1
                                                        ? "ON"
                                                        : "OFF"
                                                }}
                                            </div></label
                                        >
                                        <div class="daytimer">
                                            {{ afficheTimer(item.o) }}
                                        </div>
                                    </div>

                                    <div
                                        class="cc ccm"
                                        v-else-if="item.action == 'I'"
                                    >
                                        <div class="led-box">
                                            <input
                                                type="checkbox"
                                                v-bind:id="'switch' + i + ii"
                                                v-model="item.value"
                                                true-value='"1"'
                                                false-value='"0"'
                                            />
                                            <label
                                                @click.prevent=""
                                                v-bind:for="'switch' + i + ii"
                                            >
                                                <div
                                                    class="led-green"
                                                    :style="{
                                                        background:
                                                            item.value == 1
                                                                ? item.option
                                                                      .color
                                                                : 'gray',
                                                    }"
                                                >
                                                    {{
                                                        item.value == 1
                                                            ? "ON"
                                                            : "OFF"
                                                    }}
                                                </div></label
                                            >
                                        </div>
                                        <div
                                            class="fg"
                                            v-if="edit"
                                            @click="switchChange($event, ii, i)"
                                        ></div>
                                    </div>

                                    <div
                                        class="cc ccm"
                                        v-else-if="item.action == 'A'"
                                    >
                                        <div
                                            class="gauge__body"
                                            @click="switchChange($event, ii, i)"
                                        >
                                            <div
                                                class="gauge__fill"
                                                :style="{
                                                    transform:
                                                        'rotate(' +
                                                        Analog(
                                                            item.value,
                                                            item.o
                                                        ) *
                                                            0.005 +
                                                        'turn)',
                                                    background:
                                                        item.option.color,
                                                }"
                                            >
                                                <div
                                                    class="dm"
                                                    style="
                                                        border-top: 5px black
                                                            solid;
                                                        width: 30%;
                                                    "
                                                ></div>
                                            </div>
                                            <input
                                                type="number"
                                                v-bind:id="'switch' + i + ii"
                                                :value="
                                                    Analog(item.value, item.o)
                                                "
                                                class="gauge__cover gauge"
                                                disabled
                                                :style="{
                                                    color: item.option.color,
                                                }"
                                            />
                                        </div>
                                    </div>

                                    <div class="cc ccm" v-else>
                                        <input
                                            v-bind:id="'switch' + i + ii"
                                            @change="
                                                switchChange($event, ii, i)
                                            "
                                            :style="{
                                                background: item.option.color,
                                            }"
                                            v-model="item.value"
                                            class="
                                                rounded-lg
                                                ss
                                                overflow-hidden
                                                appearance-none
                                                bg-red-400
                                                h-5
                                                w-200
                                            "
                                            type="range"
                                            min="0"
                                            max="100"
                                            step="1"
                                        />
                                        <div
                                            class="fg"
                                            v-if="!connected || edit"
                                            @click="switchChange($event, ii, i)"
                                        ></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!--  <div class="draggable">
            <span>drag here<i class="fas fa-arrows-alt"></i><i class="far fa-hat-winter"></i></span>
            <input type="checkbox" id="switch" /><label for="switch" class="switch">Toggle</label>
          </div> -->
                    </div>
                </div>
            </div>
            <!-- /#page-content-wrapper -->
        </div>
        <!-- <div class="gauge"></div> -->
        <transition
            enter-active-class="transition duration-300 ease-out transform"
            enter-class="scale-95 opacity-0"
            enter-to-class="scale-100 opacity-100"
            leave-active-class="transition duration-300 ease-in transform"
            leave-class="scale-100 opacity-100"
            leave-to-class="scale-95 opacity-0"
        >
            <!--Modal-->
            <div
                v-if="modalOpen"
                class="
                    modal
                    z-50
                    fixed
                    w-full
                    h-full
                    top-0
                    left-0
                    flex
                    items-center
                    justify-center
                "
            >
                <div
                    @click="modalOpen = false"
                    class="
                        modal-overlay
                        absolute
                        w-full
                        h-full
                        bg-gray-900
                        opacity-30
                    "
                ></div>

                <div
                    class="
                        modal-container
                        bg-white
                        w-11/12
                        md:max-w-md
                        mx-auto
                        rounded
                        shadow-lg
                        z-50
                        overflow-y-auto
                    "
                >
                    <!-- Add margin if you want to see some of the overlay behind the modal-->
                    <div class="modal-content py-4 text-left px-6">
                        <!--Title-->
                        <div class="flex justify-between items-center pb-3">
                            <p class="text-2xl font-bold">
                                {{ options.name }} Edit
                            </p>
                            <div
                                class="modal-close cursor-pointer z-50"
                                @click="modalOpen = false"
                            >
                                <svg
                                    class="fill-current text-black"
                                    xmlns="http://www.w3.org/2000/svg"
                                    width="18"
                                    height="18"
                                    viewBox="0 0 18 18"
                                >
                                    <path
                                        d="M14.53 4.53l-1.06-1.06L9 7.94 4.53 3.47 3.47 4.53 7.94 9l-4.47 4.47 1.06 1.06L9 10.06l4.47 4.47 1.06-1.06L10.06 9z"
                                    ></path>
                                </svg>
                            </div>
                        </div>

                        <!--Body-->
                        <div class="col-span-6">
                            <label
                                class="block text-sm font-medium text-gray-700"
                                >Name</label
                            >
                            <input
                                type="text"
                                v-model="options.name"
                                name="Name"
                                autocomplete="Name"
                                class="
                                    mt-1
                                    focus:ring-indigo-500
                                    focus:border-indigo-500
                                    block
                                    w-full
                                    shadow-sm
                                    sm:text-sm
                                    border-gray-300
                                    rounded-md
                                "
                            />
                        </div>

                        <div class="col-span-6 sm:col-span-3 my-5">
                            <label
                                class="block text-sm font-medium text-gray-700"
                                >Select pin</label
                            >
                            <select
                                v-model="options.pin"
                                class="
                                    mt-1
                                    block
                                    w-full
                                    py-2
                                    px-3
                                    border border-gray-300
                                    bg-white
                                    rounded-md
                                    shadow-sm
                                    focus:outline-none
                                    focus:ring-indigo-500
                                    focus:border-indigo-500
                                    sm:text-sm
                                "
                            >
                                <option
                                    v-for="(ss, ii) in options.pins"
                                    :key="ii"
                                    :value="ii"
                                >
                                    {{ ss }}
                                </option>
                            </select>
                        </div>

                        <div class="col-span-6 sm:col-span-3 my-5">
                            <label
                                class="block text-sm font-medium text-gray-700"
                                >Position</label
                            >
                            <select
                                v-model="options.position"
                                class="
                                    mt-1
                                    block
                                    w-full
                                    py-2
                                    px-3
                                    border border-gray-300
                                    bg-white
                                    rounded-md
                                    shadow-sm
                                    focus:outline-none
                                    focus:ring-indigo-500
                                    focus:border-indigo-500
                                    sm:text-sm
                                "
                            >
                                <option value="left" selected>Left</option>
                                <option value="center">Center</option>
                                <option value="right">Right</option>
                            </select>
                        </div>
                        <div
                            v-if="options.action == 'A'"
                            class="col-span-6 sm:col-span-3 my-5"
                        >
                            <label
                                class="block text-sm font-medium text-gray-700"
                                >Sensor Type</label
                            >
                            <select
                                v-model="options.o"
                                class="
                                    mt-1
                                    w-20
                                    py-2
                                    px-3
                                    border border-gray-300
                                    bg-white
                                    rounded-md
                                    shadow-sm
                                    focus:outline-none
                                    focus:ring-indigo-500
                                    focus:border-indigo-500
                                    sm:text-sm
                                "
                            >
                                <option value="0" selected>T</option>
                                <option value="4">P</option>
                                <option value="1">L</option>
                                <option value="7">G</option>
                            </select>
                        </div>

                        <div class="col-span-6">
                            <label
                                class="block text-sm font-medium text-gray-700"
                                >Color</label
                            >
                            <input
                                v-model="options.color"
                                type="color"
                                class="
                                    border-solid
                                    h-8
                                    border-2 border-gray-300
                                "
                            />
                        </div>
                        <div class="col-span-6" v-if="options.action == 'D'">
                            <label class="inline-flex items-center">
                                <input
                                    v-model="options.time"
                                    type="checkbox"
                                    class="form-checkbox"
                                    @click="this.options.o = '0'"
                                />
                                <span class="ml-2">Timer Setting</span>
                            </label>
                        </div>
                        <div class="col-span-6" v-if="options.action == 'P'">
                            <label class="inline-flex items-center">
                                <input
                                    v-model="options.o"
                                    type="checkbox"
                                    class="form-checkbox"
                                    true-value="S"
                                    false-value="0"
                                />
                                <span class="ml-2">Servo?</span>
                            </label>
                        </div>
                        <div class="col-span-6" v-if="options.time">
                            <div>
                                <select
                                    v-model="TD[0]"
                                    class="
                                        mt-1
                                        py-2
                                        px-3
                                        w-2/6
                                        border border-gray-300
                                        bg-white
                                        rounded-md
                                        shadow-sm
                                        focus:outline-none
                                        focus:ring-indigo-500
                                        focus:border-indigo-500
                                        sm:text-sm
                                    "
                                >
                                    <option value="0" selected>Sunday</option>
                                    <option value="1">Monday</option>
                                    <option value="2">Tuesday</option>
                                    <option value="3">Wednesday</option>
                                    <option value="4">Thursday</option>
                                    <option value="5">Friday</option>
                                    <option value="6">Saturday</option>
                                </select>

                                <input
                                    type="number"
                                    v-model="TD[1]"
                                    name="Name"
                                    autocomplete="Name"
                                    class="
                                        mt-1
                                        w-20
                                        focus:ring-indigo-500
                                        focus:border-indigo-500
                                        shadow-sm
                                        sm:text-sm
                                        border-gray-300
                                        rounded-md
                                    "
                                />
                                <input
                                    type="number"
                                    v-model="TD[2]"
                                    name="Name"
                                    autocomplete="Name"
                                    class="
                                        mt-1
                                        w-20
                                        focus:ring-indigo-500
                                        focus:border-indigo-500
                                        shadow-sm
                                        sm:text-sm
                                        border-gray-300
                                        rounded-md
                                    "
                                />
                            </div>

                            <div>TO</div>
                            <div>
                                <select
                                    v-model="TD[3]"
                                    class="
                                        mt-1
                                        py-2
                                        px-3
                                        w-2/6
                                        border border-gray-300
                                        bg-white
                                        rounded-md
                                        shadow-sm
                                        focus:outline-none
                                        focus:ring-indigo-500
                                        focus:border-indigo-500
                                        sm:text-sm
                                    "
                                >
                                    <option value="0" selected>Sunday</option>
                                    <option value="1">Monday</option>
                                    <option value="2">Tuesday</option>
                                    <option value="3">Wednesday</option>
                                    <option value="4">Thursday</option>
                                    <option value="5">Friday</option>
                                    <option value="6">Saturday</option>
                                </select>
                                <input
                                    type="number"
                                    v-model="TD[4]"
                                    name="Name"
                                    autocomplete="Name"
                                    class="
                                        mt-1
                                        w-20
                                        focus:ring-indigo-500
                                        focus:border-indigo-500
                                        shadow-sm
                                        sm:text-sm
                                        border-gray-300
                                        rounded-md
                                    "
                                />
                                <input
                                    type="number"
                                    v-model="TD[5]"
                                    name="Name"
                                    autocomplete="Name"
                                    class="
                                        mt-1
                                        w-20
                                        focus:ring-indigo-500
                                        focus:border-indigo-500
                                        shadow-sm
                                        sm:text-sm
                                        border-gray-300
                                        rounded-md
                                    "
                                />
                            </div>
                        </div>

                        <button
                            @click.prevent="deleteRelay"
                            v-if="!open"
                            class="
                                bg-red-500
                                hover:bg-red-700
                                text-white
                                font-bold
                                py-2
                                px-4
                                border border-red-700
                                rounded
                            "
                        >
                            Delate
                        </button>
                        <!--Footer-->
                        <div class="flex justify-end pt-2">
                            <button
                                @click="modalOpen = false"
                                class="
                                    px-4
                                    bg-transparent
                                    p-3
                                    rounded-lg
                                    text-indigo-500
                                    hover:bg-gray-100 hover:text-indigo-400
                                    mr-2
                                "
                            >
                                Close
                            </button>
                            <button
                                @click="saveOptions"
                                class="
                                    modal-close
                                    px-4
                                    bg-indigo-500
                                    p-3
                                    rounded-lg
                                    text-white
                                    hover:bg-indigo-400
                                "
                            >
                                Save
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </transition>
        <transition
            enter-active-class="transition duration-300 ease-out transform"
            enter-class="scale-95 opacity-0"
            enter-to-class="scale-100 opacity-100"
            leave-active-class="transition duration-300 ease-in transform"
            leave-class="scale-100 opacity-100"
            leave-to-class="scale-95 opacity-0"
        >
            <div
                class="fixed z-10 inset-0 overflow-y-auto"
                aria-labelledby="modal-title"
                role="dialog"
                aria-modal="true"
                v-if="setting"
            >
                <div
                    class="
                        flex
                        items-end
                        justify-center
                        min-h-screen
                        pt-4
                        px-4
                        pb-20
                        text-center
                        sm:block sm:p-0
                    "
                >
                    <div
                        @click="setting = false"
                        class="
                            fixed
                            inset-0
                            bg-gray-500 bg-opacity-75
                            transition-opacity
                        "
                        aria-hidden="true"
                    ></div>

                    <!-- This element is to trick the browser into centering the modal contents. -->
                    <span
                        class="
                            hidden
                            sm:inline-block sm:align-middle sm:h-screen
                        "
                        aria-hidden="true"
                        >&#8203;</span
                    >

                    <div
                        class="
                            inline-block
                            align-bottom
                            bg-white
                            rounded-lg
                            text-left
                            overflow-hidden
                            shadow-xl
                            transform
                            transition-all
                            sm:my-8 sm:align-middle sm:max-w-lg sm:w-full
                        "
                    >
                        <div class="bg-white px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                            <p class="text-2xl font-bold">Setting</p>

                            <div class="mt-7">
                                <div class="col-span-6 mb-2">
                                    <label
                                        class="
                                            block
                                            text-sm
                                            font-medium
                                            text-gray-700
                                        "
                                        >Host Name</label
                                    >
                                    <input
                                        type="text"
                                        v-model="param.host"
                                        
                                        class="
                                            mt-1
                                            focus:ring-indigo-500
                                            focus:border-indigo-500
                                            block
                                            w-full
                                            shadow-sm
                                            sm:text-sm
                                            border-gray-300
                                            rounded-md
                                        "
                                    />
                                </div>

                                <div class="col-span-6">
                                    <label class="inline-flex items-center">
                                        <input
                                            v-model="param.debug"
                                            type="checkbox"
                                            class="form-checkbox"
                                            true-value="1"
                                            false-value="0"
                                        />
                                        <span class="ml-2">LCD Debug ?</span>
                                    </label>
                                </div>

                                                                <div class="col-span-6">
                                    <label class="inline-flex items-center">
                                        <input
                                            v-model="param.dark"
                                            type="checkbox"
                                            class="form-checkbox"
                                            true-value="1"
                                            false-value="0"
                                            @click="dark(1)"
                                        />
                                        <span class="ml-2">Dark Mode ?</span>
                                    </label>
                                </div>
                            </div>
                        </div>
                        <div
                            class="
                                bg-gray-50
                                px-4
                                py-3
                                sm:px-6 sm:flex sm:flex-row-reverse
                            "
                        >
                            <button
                                type="button"
                                @click="settingSave"
                                class="
                                    w-full
                                    inline-flex
                                    justify-center
                                    rounded-md
                                    border border-transparent
                                    shadow-sm
                                    px-4
                                    py-2
                                    bg-red-600
                                    text-base
                                    font-medium
                                    text-white
                                    hover:bg-red-700
                                    focus:outline-none
                                    focus:ring-2
                                    focus:ring-offset-2
                                    focus:ring-red-500
                                    sm:ml-3 sm:w-auto sm:text-sm
                                "
                            >
                                Save
                            </button>
                            <button
                                @click="setting = false"
                                type="button"
                                class="
                                    mt-3
                                    w-full
                                    inline-flex
                                    justify-center
                                    rounded-md
                                    border border-gray-300
                                    shadow-sm
                                    px-4
                                    py-2
                                    bg-white
                                    text-base
                                    font-medium
                                    text-gray-700
                                    hover:bg-gray-50
                                    focus:outline-none
                                    focus:ring-2
                                    focus:ring-offset-2
                                    focus:ring-indigo-500
                                    sm:mt-0 sm:ml-3 sm:w-auto sm:text-sm
                                "
                            >
                                Cancel
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </transition>
    </app-layout>
</template>

<script>
var dragOptions = {
    distance: 10,
    grid: [10, 10],
    opacity: 0.35,
    handle: "span",
    containment: "parent",
};
var resizOptions = { distance: 10, grid: [50, 20] };
import AppLayout from "@/Layouts/AppLayout";
const pins = {
    D: {
        2: "R1",
        3: "R2",
        4: "R3",
        6: "R4",
        7: "R5",
        8: "R6",
    },
    A: {
        16: "A1",
        15: "A2",
        17: "A3",
    },
    I: {
        15: "I1",
        14: "I2",
        12: "I3",
        13: "I4",
    },
    P: {
        9: "P1",
        10: "P2",
        11: "P3",
    },
};
export default {
    props: {
        params: Object,
        user: Object,
    },
    components: {
        AppLayout,
    },
    data: function () {
        return {
            value: 26,
            connected: false,
            open: false,
            dimmer: true,
            right: false,
            data: {
                left: [],
                center: [],
                right: [],
            },
            i: 0,
            edit: false,
            options: {
                pin: 2,
                color: "black",
                name: "relay1",
                index: 0,
                position: "left",
                o: "",
                time: false,
                pins: [],
            },
            usedPins: [],
            client: {},
            modalOpen: false,
            heights: [],
            param: this.params,
            setting: false,
            
        };
    },
   
    computed: {
        // a computed getter
        TD: function () {
            // `this` points to the vm instance
            var c = this.options.o.split(",");
            c[6] = 0;
            return c;
        },
    },
    mounted() {
        console.log(pins);
        this.dark(0);
        axios.defaults.withCredentials = true;
        //console.log(this.user);
        axios.get("/items/" + this.user.id, {}).then((response) => {
            this.data = {
                left: response.data.hasOwnProperty("left")
                    ? [...response.data.left]
                    : [],
                center: response.data.hasOwnProperty("center")
                    ? [...response.data.center]
                    : [],
                right: response.data.hasOwnProperty("right")
                    ? [...response.data.right]
                    : [],
            };
            var result = this.data.left.map((a) => a.pin);
            result = result.concat(this.data.center.map((a) => a.pin));
            this.usedPins = result.concat(this.data.right.map((a) => a.pin));
            //console.log(this.usedPins);
            // var v = [1,13];
            //         var result2  = result.filter(function(o){return !v.includes(o);} );
            //       console.log(result2);
            //this.generateData();
            //this.$forceUpdate();
            this.connectToMqtt();
        });

        //this.switchChange("f");
    },
    methods: {
        dark(a){
            //alert(this.params.dark);
            if(this.params.dark == a){
                $(".ccm").removeClass("ccmDark");
            }else{
                 $(".ccm").addClass("ccmDark");
            }
        },
        settingSave() {
            const k = {
                debug: this.params.debug,
                host: this.params.host,
                dark:this.params.dark,
                id: this.params.id,
            };
            axios.post("/items/setting", k).then((response) => {
                console.log(response);
                this.setting = false;
            });
              if(this.client._getHost() != k.host){
                  if(this.connected)
                 this.client.disconnect();
                  this.connectToMqtt();
               }
            if(this.connected){
               delete k.id,k.dark;
               k.action = "Z";
                var message = new Paho.MQTT.Message(JSON.stringify(k));
                message.destinationName = "iot-2/" + this.params.code;
                this.client.send(message);
                console.log(k);
            }
        },
        afficheTimer(o) {
            // console.log(o);
            var c = o.split(",");
            var str = "";
            if (c.length <= 5) return "";
            switch (parseInt(c[0])) {
                case 0:
                    str += "Sunday";
                    break;
                case 1:
                    str += "Monday";
                    break;
                case 2:
                    str += "Tuesday";
                    break;
                case 3:
                    str += "Wednesday";
                    break;
                case 4:
                    str += "Thursday";
                    break;
                case 5:
                    str += "Friday";
                    break;
                case 6:
                    str += "Saturday";
                    break;
                default:
                    str += "AllDay";
            }
            str +=
                " at " + this.checkd(c[1]) + ":" + this.checkd(c[2]) + " => ";
            switch (parseInt(c[3])) {
                case 0:
                    str += "Sunday";
                    break;
                case 1:
                    str += "Monday";
                    break;
                case 2:
                    str += "Tuesday";
                    break;
                case 3:
                    str += "Wednesday";
                    break;
                case 4:
                    str += "Thursday";
                    break;
                case 5:
                    str += "Friday";
                    break;
                case 6:
                    str += "Saturday";
                    break;
                default:
                    str += "AllDay";
            }
            str += " at " + this.checkd(c[4]) + ":" + this.checkd(c[5]);
            return str;
        },
        checkd(s) {
            return s.length == 1 ? "0" + s : s;
        },
        Analog(a, o) {
            if (o == "0") {
                const R1 = 10000;
                var logR2, R2, T;
                const c1 = 1.009249522e-3,
                    c2 = 2.378405444e-4,
                    c3 = 2.019202697e-7;
                R2 = R1 * (100 / parseInt(a) - 1.0);
                logR2 = Math.log(R2);
                T = 1.0 / (c1 + c2 * logR2 + c3 * logR2 * logR2 * logR2);
                T = T - 273.15;
                T = (T * 9.0) / 5.0 + 32.0;
                //console.log(T);
                return parseFloat(T).toFixed(2);
            }
        },
        deleteRelay() {
            //console.log( this.data[this.options.position][this.options.index]);
            if (confirm("Are you sure you want to delete?")) {
                var c = { id: this.options.id };
                var msg = {
                    pin: this.options.pin,
                    action: "X",
                    id: this.options.id,
                };
                var message = new Paho.MQTT.Message(JSON.stringify(msg));
                message.destinationName = "iot-2/" + this.params.code;
                this.client.send(message);
                console.log(msg);
                axios.post("/items/delete", c).then((response) => {
                    $("body .draggable")
                        .draggable("destroy")
                        .resizable("destroy");
                    $("body .res").resizable("destroy");
                    this.edit = false;
                    this.modalOpen = false;
                    this.open = false;
                    this.data = {
                        left: response.data.hasOwnProperty("left")
                            ? [...response.data.left]
                            : [],
                        center: response.data.hasOwnProperty("center")
                            ? [...response.data.center]
                            : [],
                        right: response.data.hasOwnProperty("right")
                            ? [...response.data.right]
                            : [],
                    };

                    var result = this.data.left.map((a) => a.pin);
                    result = result.concat(this.data.center.map((a) => a.pin));
                    this.usedPins = result.concat(
                        this.data.right.map((a) => a.pin)
                    );
                });
            }
        },
        cancel() {
            axios.get("/items/" + this.user.id, {}).then((response) => {
                this.data = response.data;
                this.i = response.data.length;
                this.edit = false;
                $("body .draggable").draggable("destroy").resizable("destroy");
                $("body .res").resizable("destroy");
            });
        },
        saveOptions() {
            var msg;

            if (!this.open) {
                var pos = $(
                    "#switch" + this.options.index + this.options.pos
                ).position();
                this.data[this.options.pos][this.options.index].pin = parseInt(
                    this.options.pin
                );
                this.data[this.options.pos][this.options.index].option.name =
                    this.options.name;
                this.data[this.options.pos][this.options.index].option.color =
                    this.options.color;
                this.data[this.options.pos][this.options.index].position =
                    this.options.position;

                this.data[this.options.pos][this.options.index].action =
                    this.options.action;

                this.data[this.options.pos][this.options.index].option.width =
                    pos.width;
                this.data[this.options.pos][this.options.index].option.height =
                    pos.height;
                if (this.options.time)
                    this.data[this.options.pos][this.options.index].o =
                        this.TD.join(",");
                else
                    this.data[this.options.pos][this.options.index].o =
                        this.options.o;
                // ['left','center','right'].forEach(pos => {

                // });
                msg = { ...this.data[this.options.pos][this.options.index] };
                this.$forceUpdate();
            } else {
                this.data[this.options.position][
                    this.data[this.options.position].length
                ] = {
                    action: this.options.action,
                    pin: parseInt(this.options.pin),
                    position: this.options.position,
                    value: "0",
                    user_id: this.user.id,
                    option: {
                        name: this.options.name,
                        color: this.options.color,
                        top: 0,
                        left: 0,
                        width: 0,
                        height: 0,
                    },
                    o: this.options.time ? this.TD.join(",") : "0",
                };
                this.open = false;
                msg = {
                    ...this.data[this.options.position][
                        this.data[this.options.position].length - 1
                    ],
                };
                this.$forceUpdate();
                this.$nextTick(function () {
                    if (this.edit) {
                        $("body .draggable-ui")
                            .draggable("destroy")
                            .resizable("destroy");
                        $("body .draggable")
                            .draggable(dragOptions)
                            .resizable(resizOptions);
                    }
                    console.log("updated");
                });
            }

            if (this.connected) {
                delete msg.option;

                console.log(msg);

                var message = new Paho.MQTT.Message(JSON.stringify(msg));
                message.destinationName = "iot-2/" + this.params.code;
                this.client.send(message);
            }

            this.modalOpen = false;
        },
        toggle() {
            this.open = !this.open;
        },
        starEdit() {
            this.edit = true;
            $("body .draggable-ui").draggable("destroy").resizable("destroy");
            $("body .draggable").draggable(dragOptions).resizable(resizOptions);
            $("body .res").resizable({
                minHeight: 200,
            });
        },
        switchChange(event, ii, i) {
            console.log(event.type);
            if (!this.edit) {
                if (this.connected) {
                    var msg = { ...this.data[ii][i] };
                    if (event.type == "click") {
                        msg.value = msg.value == "1" ? "0" : "1";
                    }
                    delete msg.option;
                    console.log(msg);
                    //msg.value = msg.value.toString();;

                    var message = new Paho.MQTT.Message(JSON.stringify(msg));
                    message.destinationName = "iot-2/" + this.params.code;
                    this.client.send(message);
                    axios.post("/items/update", msg).then((response) => {
                        console.log(response);
                    });
                }
                event.preventDefault();
            } else {
                event.preventDefault();
                var c = { ...pins[this.data[ii][i].action] };
                var t = [...this.usedPins];
                delete t[t.indexOf(this.data[ii][i].pin)];
                console.log(t);
                console.log(this.data[ii][i].pin);
                console.log(c);
                //console.log(Object.keys(c).filter(function(o){return !t.includes(4);} ));
                t.forEach((element) => {
                    delete c[element];
                });
                console.log(c);
                //  var result2  = result.filter(function(o){return !v.includes(o);} );
                this.options = {
                    id: this.data[ii][i].id,
                    name: this.data[ii][i].option.name,
                    color: this.data[ii][i].option.color,
                    pin: this.data[ii][i].pin,
                    position: this.data[ii][i].position,
                    action: this.data[ii][i].action,
                    o: this.data[ii][i].o,
                    time: this.data[ii][i].o.length > 6,
                    index: i,
                    pos: ii,
                    pins: c,
                };
                this.modalOpen = true;
                //$('#staticBackdrop').modal('show');
            }
        },
        generateData() {
            data.forEach(function (item, index) {
                var $element = $(
                    '<div class="ui-widget-content draggable"><span>drag here</span><input type="checkbox" @click="switchChange()" id="switch' +
                        index +
                        '" /><label for="switch' +
                        index +
                        '" class="switch">Toggle</label></div>'
                );
                $("#space").append($element);
                $element.draggable(dragOptions).resizable(resizOptions);
                $element.data("index", index);
                $element.css({
                    top: data[index].option.top + "px",
                    left: data[index].option.left + "px",
                    width: data[index].option.width + "px",
                    height: data[index].option.height + "px",
                });
            });
        },
        save() {
            var c = [
                ...this.data["left"],
                ...this.data["center"],
                ...this.data["right"],
            ];
            $("body .draggable").each(function (index) {
                const pos = $(this).position();
                delete c[index].value;
                c[index].option = {
                    top: pos.top,
                    left: pos.left,
                    width: $(this).outerWidth(),
                    height: $(this).outerHeight(),
                    name: c[index].option.name,
                    color: c[index].option.color,
                };
            });

            var cc = {};
            $(".res").each(function (index) {
                cc[index] = $(this).outerHeight();
            });
            this.param = {
                id: this.param.id,
                left: cc[0],
                center: cc[1],
                right: cc[2],
                code: this.param.code,
            };
            var k = {
                items: c,
                params: this.param,
            };
            // console.log(k);

            axios.post("/items/set", k).then((response) => {
                console.log(response);
                $("body .draggable").draggable("destroy").resizable("destroy");
                $("body .res").resizable("destroy");
                this.edit = false;
                this.data = {
                    left: response.data.hasOwnProperty("left")
                        ? [...response.data.left]
                        : [],
                    center: response.data.hasOwnProperty("center")
                        ? [...response.data.center]
                        : [],
                    right: response.data.hasOwnProperty("right")
                        ? [...response.data.right]
                        : [],
                };
            });
        },
        addRelay(action = "D") {
            var c = { ...pins[action] };
            var t = [...this.usedPins];
            //console.log(Object.keys(c).filter(function(o){return !t.includes(4);} ));
            t.forEach((element) => {
                delete c[element];
            });
            console.log(c);
            this.options = {
                color: "red",
                position: "left",
                name: "new relay",
                action: action,
                pins: c,
            };
            this.modalOpen = true;
            // console.log(this.data);
            // this.i++;
            // this.$forceUpdate();
            // this.$nextTick(function () {
            //     if(this.edit){
            //       $( "body .draggable-ui" ).draggable( "destroy" ).resizable( "destroy" );
            //       $( "body .draggable" ).draggable(dragOptions).resizable(resizOptions);
            //     }
            //     console.log("updated");
            // });
        },
        connectToMqtt() {
            console.log("mqtt");
            this.client = new Paho.MQTT.Client(
               this.params.host,
                9001,
                "hh" + Math.floor(Math.random() * 11)
            );
            this.client.reconnect = true;
            this.client.onConnectionLost = this.onConnectionLost;
            this.client.onMessageArrived = this.onMessageArrived;
            this.client.connect({
                onSuccess: this.onConnect,
                keepAliveInterval: 5,
                reconnect: true,
            });
        },
        onConnect() {
            console.log("onConnect");
            this.connected = true;
            this.client.subscribe("iot-2/" + this.params.code);
        },
        onConnectionLost(responseObject) {
            if (responseObject.errorCode !== 0) {
                console.log("onConnectionLost:" + responseObject.errorMessage);
            }
            // this.connectToMqtt();
            this.connected = false;
        },
        onMessageArrived(message) {
            var d = JSON.parse(message.payloadString);
            //console.log(d);
            var e = { pos: "a" };
            for (const key in this.data) {
                const pos = this.data[key];
                pos.forEach((element, i) => {
                    if (element.pin == d.pin) {
                        e = {
                            pos: key,
                            index: i,
                        };
                        return;
                    }
                });
                if (e.pos != "a") {
                    console.log(e);
                    break;
                }
            }
            if (e.pos == "a") {
                console.log("index not found");
                return;
            }
            this.data[e.pos][e.index].value = d.value;
            var msg = this.data[e.pos][e.index];
            if (msg.id) {
                if (d.action == "I" || d.action == "A") {
                    axios.post("/items/update", msg).then((response) => {
                        console.log(response);
                    });
                }
            }
        },
    },
};
</script>
<style>
.fade-enter-active,
.fade-leave-active {
    transition: opacity 1s ease-out;
}

.fade-enter,
.fade-leave-to {
    opacity: 0;
}
.sd {
    display: inline-table;
}
.sm {
    width: 100%;
    height: 100%;
    background: #2f2f2f;
    position: absolute;
    opacity: 0.4;
}
.ui-resizable-handle {
    z-index: 40 !important;
}
.rows {
    position: relative;
    height: 400px;
}
.res > .ui-resizable-e,
.res > .ui-resizable-se {
    display: none !important;
}
button i {
    /* font-size: 32px; */
}

#com {
    font-size: 28px;
    font-weight: bold;
    text-shadow: 2px 10px 6px #2d2c2c;
}
input[type="range"]::-webkit-slider-thumb {
    width: 20px;
    -webkit-appearance: none;
    appearance: none;
    height: 100vh;
    background: #fff;
    box-shadow: 405px 0 0 400px #a7a7a7;
    border-radius: 50%;
}
.ss {
    width: 100%;
    height: 100%;
}
.ui-widget-content.draggable {
    height: 100%;
}
.fg {
    position: absolute;
    top: 0;
    height: 100%;
    width: 100%;
}
.led-box {
    height: 100%;
    width: 100%;
    float: left;
}

.led-box p {
    font-size: 12px;
    text-align: center;
}

.led-green {
    margin: 0 auto;
    width: 100%;
    height: 100%;
    background-color: #abff00;
    border-radius: 50%;
    box-shadow: rgba(0, 0, 0, 0.2) 0 -1px 7px 1px, inset #304701 0 -1px 9px;

    display: flex;
    align-items: center;
    justify-content: center;

    color: white;
    padding: 10% 0px;
    text-align: center;
    font-size: 1.4rem;
    font-weight: bold;
}
.gauge {
    width: 100%;
    max-width: 250px;
    font-family: "Roboto", sans-serif;
    font-size: 32px;
    color: #004033;
    text-align: center;
}

.gauge__body {
    width: 100%;
    height: 0;
    padding-bottom: 50%;
    background: #b4c0be;
    position: relative;
    border-top-left-radius: 100% 200%;
    border-top-right-radius: 100% 200%;
    overflow: hidden;
}

.gauge__fill {
    position: absolute;
    top: 100%;
    left: 0;
    width: inherit;
    height: 100%;
    background: #009578;
    transform-origin: center top;
    /* transform: rotate(0.25turn);*/
    transition: transform 0.4s ease-out;
}

.gauge__cover {
    width: 75%;
    height: 150%;
    background: #ffffff;
    border-radius: 50%;
    position: absolute;
    top: 25%;
    left: 50%;
    transform: translateX(-50%);

    /* Text */
    display: flex;
    align-items: center;
    justify-content: center;
    padding-bottom: 25%;
    box-sizing: border-box;
}
.daytimer {
    font-size: 12px;
    text-align: center;
    font-family: emoji;
    font-weight: bold;
}
</style>
