<template>
    <div class="window-container">
        <div class="vac-card-window">
            <div class="vac-chat-container">
                <div class="vac-rooms-container vac-app-border-r">
                    <div class="vac-box-search">
                        <div class="vac-icon-search">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24">
                                <path
                                    id="vac-icon-search"
                                    d="M9.5,3A6.5,6.5 0 0,1 16,9.5C16,11.11 15.41,12.59 14.44,13.73L14.71,14H15.5L20.5,19L19,20.5L14,15.5V14.71L13.73,14.44C12.59,15.41 11.11,16 9.5,16A6.5,6.5 0 0,1 3,9.5A6.5,6.5 0 0,1 9.5,3M9.5,5C7,5 5,7 5,9.5C5,12 7,14 9.5,14C12,14 14,12 14,9.5C14,7 12,5 9.5,5Z"
                                ></path>
                            </svg>
                        </div>
                        <input type="search" placeholder="Search" autocomplete="off" class="vac-input" />
                        <div class="vac-svg-button vac-add-icon">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24">
                                <path
                                    id="vac-icon-add"
                                    d="M17,13H13V17H11V13H7V11H11V7H13V11H17M12,2A10,10 0 0,0 2,12A10,10 0 0,0 12,22A10,10 0 0,0 22,12A10,10 0 0,0 12,2Z"
                                ></path>
                                <!---->
                            </svg>
                        </div>
                    </div>
                    <!----><!---->
                    <div class="vac-room-list">
                        <div class="vac-room-item">
                            <div class="vac-room-container">
                                <div
                                    class="vac-avatar"
                                    style="
                                        background-image: url('https://images.unsplash.com/photo-1619060303466-f59b9e35e2e3?ixid=MnwxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8&ixlib=rb-1.2.1&auto=format&fit=crop&w=333&q=80');
                                    "
                                ></div>
                                <div class="vac-name-container vac-text-ellipsis">
                                    <div class="vac-title-container">
                                        <!---->
                                        <div class="vac-room-name vac-text-ellipsis">123</div>
                                        <div class="vac-text-date">25/04/2021</div>
                                    </div>
                                    <div class="vac-text-last">
                                        <!---->
                                        <div class="vac-format-message-wrapper vac-text-ellipsis">
                                            <div class="vac-text-ellipsis">
                                                <span class="vac-text-ellipsis">
                                                    <!----><span>Room created</span>
                                                </span>
                                            </div>
                                        </div>
                                        <!---->
                                        <div class="vac-room-options-container">
                                            <!---->
                                            <div class="vac-svg-button vac-list-room-options">
                                                <svg
                                                    xmlns="http://www.w3.org/2000/svg"
                                                    width="24"
                                                    height="24"
                                                    viewBox="0 0 24 24"
                                                >
                                                    <path
                                                        id="vac-icon-dropdown-room"
                                                        d="M7.41,8.58L12,13.17L16.59,8.58L18,10L12,16L6,10L7.41,8.58Z"
                                                    ></path>
                                                    <!---->
                                                </svg>
                                            </div>
                                            <!---->
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="vac-room-item vac-room-selected">
                            <div class="vac-room-container">
                                <div
                                    class="vac-avatar"
                                    style="
                                        background-image: url('https://images.unsplash.com/photo-1591532149076-fdf41b8d3270?ixid=MnwxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8&ixlib=rb-1.2.1&auto=format&fit=crop&w=334&q=80');
                                    "
                                ></div>
                                <div class="vac-name-container vac-text-ellipsis">
                                    <div class="vac-title-container">
                                        <!---->
                                        <div class="vac-room-name vac-text-ellipsis">Leia, R.O., luke</div>
                                        <div class="vac-text-date">24/04/2021</div>
                                    </div>
                                    <div class="vac-text-last">
                                        <!---->
                                        <div class="vac-format-message-wrapper vac-text-ellipsis">
                                            <div class="vac-text-ellipsis">
                                                <span class="vac-text-ellipsis"> <!----><span>werwer</span> </span>
                                            </div>
                                        </div>
                                        <!---->
                                        <div class="vac-room-options-container">
                                            <!---->
                                            <div class="vac-svg-button vac-list-room-options">
                                                <svg
                                                    xmlns="http://www.w3.org/2000/svg"
                                                    width="24"
                                                    height="24"
                                                    viewBox="0 0 24 24"
                                                >
                                                    <path
                                                        id="vac-icon-dropdown-room"
                                                        d="M7.41,8.58L12,13.17L16.59,8.58L18,10L12,16L6,10L7.41,8.58Z"
                                                    ></path>
                                                    <!---->
                                                </svg>
                                            </div>
                                            <!---->
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="vac-room-item">
                            <div class="vac-room-container">
                                <div
                                    class="vac-avatar"
                                    style="
                                        background-image: url(https://images.unsplash.com/photo-1596982288494-41e4edbf1047?ixid=MnwxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8&ixlib=rb-1.2.1&auto=format&fit=crop&w=334&q=80);
                                    "
                                ></div>
                                <div class="vac-name-container vac-text-ellipsis">
                                    <div class="vac-title-container">
                                        <!---->
                                        <div class="vac-room-name vac-text-ellipsis">testAshraful, lo</div>
                                        <div class="vac-text-date">24/04/2021</div>
                                    </div>
                                    <div class="vac-text-last">
                                        <!---->
                                        <div class="vac-format-message-wrapper vac-text-ellipsis">
                                            <div class="vac-text-ellipsis">
                                                <span class="vac-text-ellipsis"> <!----><span>sorry</span> </span>
                                            </div>
                                        </div>
                                        <!---->
                                        <div class="vac-room-options-container">
                                            <!---->
                                            <div class="vac-svg-button vac-list-room-options">
                                                <svg
                                                    xmlns="http://www.w3.org/2000/svg"
                                                    width="24"
                                                    height="24"
                                                    viewBox="0 0 24 24"
                                                >
                                                    <path
                                                        id="vac-icon-dropdown-room"
                                                        d="M7.41,8.58L12,13.17L16.59,8.58L18,10L12,16L6,10L7.41,8.58Z"
                                                    ></path>
                                                    <!---->
                                                </svg>
                                            </div>
                                            <!---->
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!--loader-->
                    </div>
                </div>
                <div class="vac-col-messages">
                    <div class="vac-room-header vac-app-border-b">
                        <div class="vac-room-wrapper">
                            <div class="vac-svg-button vac-toggle-button">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24">
                                    <path
                                        id="vac-icon-toggle"
                                        d="M5,13L9,17L7.6,18.42L1.18,12L7.6,5.58L9,7L5,11H21V13H5M21,6V8H11V6H21M21,16V18H11V16H21Z"
                                    ></path>
                                    <!---->
                                </svg>
                            </div>
                            <div class="vac-info-wrapper">
                                <div
                                    class="vac-avatar"
                                    style="
                                        background-image: url('https://images.unsplash.com/photo-1591532149076-fdf41b8d3270?ixid=MnwxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8&ixlib=rb-1.2.1&auto=format&fit=crop&w=334&q=80');
                                    "
                                ></div>
                                <div class="vac-text-ellipsis">
                                    <div class="vac-room-name vac-text-ellipsis">Leia, R.O., luke</div>
                                    <div class="vac-room-info vac-text-ellipsis"></div>
                                </div>
                            </div>
                            <div class="vac-svg-button vac-room-options">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24">
                                    <path
                                        id="vac-icon-menu"
                                        d="M12,16A2,2 0 0,1 14,18A2,2 0 0,1 12,20A2,2 0 0,1 10,18A2,2 0 0,1 12,16M12,10A2,2 0 0,1 14,12A2,2 0 0,1 12,14A2,2 0 0,1 10,12A2,2 0 0,1 12,10M12,4A2,2 0 0,1 14,6A2,2 0 0,1 12,8A2,2 0 0,1 10,6A2,2 0 0,1 12,4Z"
                                    ></path>
                                    <!---->
                                </svg>
                            </div>
                            <!---->
                        </div>
                    </div>
                    <div class="vac-container-scroll">
                        <!---->
                        <div class="vac-messages-container">
                            <div class="">
                                <div class="vac-text-started">Conversation started on: 1 April 2021</div>
                                <!--loader-->
                                <span>
                                    <div class="vac-message-wrapper">
                                        <!----><!---->
                                        <div class="vac-message-box vac-offset-current">
                                            <!---->
                                            <div class="vac-message-container">
                                                <div class="vac-message-card vac-message-current">
                                                    <!----><!---->
                                                    <div class="vac-format-message-wrapper">
                                                        <div class="">
                                                            <span class=""> <!----><span>hello</span> </span>
                                                        </div>
                                                    </div>
                                                    <!---->
                                                    <div class="vac-text-timestamp">
                                                        <!----><span>12:44</span>
                                                        <span>
                                                            <svg
                                                                xmlns="http://www.w3.org/2000/svg"
                                                                width="24"
                                                                height="24"
                                                                viewBox="0 0 24 24"
                                                                class="vac-icon-check"
                                                            >
                                                                <path
                                                                    id="vac-icon-double-checkmark-seen"
                                                                    d="M18 7l-1.41-1.41-6.34 6.34 1.41 1.41L18 7zm4.24-1.41L11.66 16.17 7.48 12l-1.41 1.41L11.66 19l12-12-1.42-1.41zM.41 13.41L6 19l1.41-1.41L1.83 12 .41 13.41z"
                                                                ></path>
                                                                <!---->
                                                            </svg>
                                                        </span>
                                                    </div>
                                                    <div class="vac-message-actions-wrapper">
                                                        <div
                                                            class="vac-options-container"
                                                            style="display: initial; width: 70px"
                                                        >
                                                            <span></span>
                                                        </div>
                                                        <!---->
                                                    </div>
                                                </div>
                                                <span></span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="vac-message-wrapper">
                                        <!----><!---->
                                        <div class="vac-message-box">
                                            <!---->
                                            <div class="vac-message-container">
                                                <div class="vac-message-card">
                                                    <div class="vac-text-username"><span>Leia</span></div>
                                                    <!---->
                                                    <div>
                                                        <div class="vac-audio-player">
                                                            <div class="vac-svg-button">
                                                                <svg
                                                                    xmlns="http://www.w3.org/2000/svg"
                                                                    width="24"
                                                                    height="24"
                                                                    viewBox="0 0 48 48"
                                                                >
                                                                    <path
                                                                        id="vac-icon-audio-play"
                                                                        d="M43.331,21.237L7.233,0.397c-0.917-0.529-2.044-0.529-2.96,0c-0.916,0.528-1.48,1.505-1.48,2.563v41.684   c0,1.058,0.564,2.035,1.48,2.563c0.458,0.268,0.969,0.397,1.48,0.397c0.511,0,1.022-0.133,1.48-0.397l36.098-20.84   c0.918-0.529,1.479-1.506,1.479-2.564S44.247,21.767,43.331,21.237z"
                                                                    ></path>
                                                                    <!---->
                                                                </svg>
                                                            </div>
                                                            <div class="vac-player-bar">
                                                                <div class="vac-player-progress">
                                                                    <div class="vac-line-container">
                                                                        <div
                                                                            class="vac-line-progress"
                                                                            style="width: 0"
                                                                        ></div>
                                                                        <div class="vac-line-dot" style="left: 0"></div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <audio src="#"></audio>
                                                        </div>
                                                    </div>
                                                    <div class="vac-progress-time">00:05</div>
                                                    <div class="vac-text-timestamp">
                                                        <!----><span>16:26</span
                                                        ><!---->
                                                    </div>
                                                    <div class="vac-message-actions-wrapper">
                                                        <div
                                                            class="vac-options-container"
                                                            style="display: initial; width: 70px"
                                                        >
                                                            <span></span>
                                                        </div>
                                                        <!---->
                                                    </div>
                                                </div>
                                                <span
                                                    ><button class="vac-button-reaction" style="float: left">
                                                        😂<span>1</span>
                                                    </button></span
                                                >
                                            </div>
                                        </div>
                                    </div>
                                    <div class="vac-message-wrapper">
                                        <!----><!---->
                                        <div class="vac-message-box">
                                            <!---->
                                            <div class="vac-message-container vac-message-container-offset">
                                                <div class="vac-message-card">
                                                    <div class="vac-text-username"><span>Leia</span></div>
                                                    <!---->
                                                    <div class="vac-format-message-wrapper">
                                                        <div class="">
                                                            <span class=""> <!----><span>uup</span> </span>
                                                        </div>
                                                    </div>
                                                    <!---->
                                                    <div class="vac-text-timestamp">
                                                        <!----><span>04:53</span
                                                        ><!---->
                                                    </div>
                                                    <div class="vac-message-actions-wrapper">
                                                        <div
                                                            class="vac-options-container"
                                                            style="display: initial; width: 70px"
                                                        >
                                                            <span></span>
                                                        </div>
                                                        <!---->
                                                    </div>
                                                </div>
                                                <span></span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="vac-message-wrapper">
                                        <!----><!---->
                                        <div class="vac-message-box">
                                            <!---->
                                            <div class="vac-message-container vac-message-container-offset">
                                                <div class="vac-message-card vac-message-deleted">
                                                    <div class="vac-text-username"><span>Leia</span></div>
                                                    <!---->
                                                    <div>
                                                        <svg
                                                            xmlns="http://www.w3.org/2000/svg"
                                                            width="24"
                                                            height="24"
                                                            viewBox="0 0 24 24"
                                                            class="vac-icon-deleted"
                                                        >
                                                            <path
                                                                id="vac-icon-deleted"
                                                                d="M12,2A10,10 0 0,1 22,12A10,10 0 0,1 12,22A10,10 0 0,1 2,12A10,10 0 0,1 12,2M12,4A8,8 0 0,0 4,12C4,13.85 4.63,15.55 5.68,16.91L16.91,5.68C15.55,4.63 13.85,4 12,4M12,20A8,8 0 0,0 20,12C20,10.15 19.37,8.45 18.32,7.09L7.09,18.32C8.45,19.37 10.15,20 12,20Z"
                                                            ></path>
                                                            <!---->
                                                        </svg>
                                                        <span>This message was deleted</span>
                                                    </div>
                                                    <!---->
                                                    <div class="vac-text-timestamp">
                                                        <!----><span>16:57</span
                                                        ><!---->
                                                    </div>
                                                    <div class="vac-message-actions-wrapper">
                                                        <div
                                                            class="vac-options-container"
                                                            style="display: initial; width: 70px"
                                                        >
                                                            <span></span>
                                                        </div>
                                                        <!---->
                                                    </div>
                                                </div>
                                                <!---->
                                            </div>
                                        </div>
                                    </div>
                                    <div class="vac-message-wrapper">
                                        <!----><!---->
                                        <div class="vac-message-box">
                                            <!---->
                                            <div class="vac-message-container">
                                                <div class="vac-message-card">
                                                    <div class="vac-text-username"><span>Leia</span></div>
                                                    <!---->
                                                    <div class="vac-format-message-wrapper">
                                                        <div class="">
                                                            <span class=""> <!----><span>🙉</span> </span>
                                                        </div>
                                                    </div>
                                                    <!---->
                                                    <div class="vac-text-timestamp">
                                                        <!----><span>18:25</span
                                                        ><!---->
                                                    </div>
                                                    <div class="vac-message-actions-wrapper">
                                                        <div
                                                            class="vac-options-container"
                                                            style="display: initial; width: 70px"
                                                        >
                                                            <span></span>
                                                        </div>
                                                        <!---->
                                                    </div>
                                                </div>
                                                <span></span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="vac-message-wrapper">
                                        <div class="vac-card-info vac-card-date">21 April 2021</div>
                                        <!---->
                                        <div class="vac-message-box vac-offset-current">
                                            <!---->
                                            <div class="vac-message-container vac-message-container-offset">
                                                <div class="vac-message-card vac-message-current vac-message-deleted">
                                                    <!----><!---->
                                                    <div>
                                                        <svg
                                                            xmlns="http://www.w3.org/2000/svg"
                                                            width="24"
                                                            height="24"
                                                            viewBox="0 0 24 24"
                                                            class="vac-icon-deleted"
                                                        >
                                                            <path
                                                                id="vac-icon-deleted"
                                                                d="M12,2A10,10 0 0,1 22,12A10,10 0 0,1 12,22A10,10 0 0,1 2,12A10,10 0 0,1 12,2M12,4A8,8 0 0,0 4,12C4,13.85 4.63,15.55 5.68,16.91L16.91,5.68C15.55,4.63 13.85,4 12,4M12,20A8,8 0 0,0 20,12C20,10.15 19.37,8.45 18.32,7.09L7.09,18.32C8.45,19.37 10.15,20 12,20Z"
                                                            ></path>
                                                            <!---->
                                                        </svg>
                                                        <span>This message was deleted</span>
                                                    </div>
                                                    <!---->
                                                    <div class="vac-text-timestamp">
                                                        <!----><span>16:04</span
                                                        ><!---->
                                                    </div>
                                                    <div class="vac-message-actions-wrapper">
                                                        <div
                                                            class="vac-options-container"
                                                            style="display: initial; width: 70px"
                                                        >
                                                            <span></span>
                                                        </div>
                                                        <!---->
                                                    </div>
                                                </div>
                                                <!---->
                                            </div>
                                        </div>
                                    </div>
                                </span>
                            </div>
                        </div>
                    </div>
                    <div>
                        <div class="vac-icon-scroll">
                            <!---->
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24">
                                <path
                                    id="vac-icon-dropdown-scroll"
                                    d="M7.41,8.58L12,13.17L16.59,8.58L18,10L12,16L6,10L7.41,8.58Z"
                                ></path>
                                <!---->
                            </svg>
                        </div>
                    </div>
                    <div class="vac-room-footer" style="">
                        <!----><!----><!---->
                        <div class="vac-box-footer">
                            <div class="vac-icon-textarea-left">
                                <div class="vac-svg-button">
                                    <svg
                                        xmlns="http://www.w3.org/2000/svg"
                                        width="24"
                                        height="24"
                                        viewBox="0 0 512 512"
                                        class="vac-icon-microphone"
                                    >
                                        <path
                                            id="vac-icon-microphone"
                                            d="M432.8,216.4v39.2c0,45.2-15.3,84.3-45.2,118.4c-29.8,33.2-67.3,52.8-111.6,57.9v40.9h78.4c5.1,0,10.2,1.7,13.6,6c4.3,4.3,6,8.5,6,13.6c0,5.1-1.7,10.2-6,13.6c-4.3,4.3-8.5,6-13.6,6H157.6c-5.1,0-10.2-1.7-13.6-6c-4.3-4.3-6-8.5-6-13.6c0-5.1,1.7-10.2,6-13.6c4.3-4.3,8.5-6,13.6-6H236v-40.9c-44.3-5.1-81.8-23.9-111.6-57.9s-45.2-73.3-45.2-118.4v-39.2c0-5.1,1.7-10.2,6-13.6c4.3-4.3,8.5-6,13.6-6s10.2,1.7,13.6,6c4.3,4.3,6,8.5,6,13.6v39.2c0,37.5,13.6,70.7,40,97.1s59.6,40,97.1,40s70.7-13.6,97.1-40c26.4-26.4,40-59.6,40-97.1v-39.2c0-5.1,1.7-10.2,6-13.6c4.3-4.3,8.5-6,13.6-6c5.1,0,10.2,1.7,13.6,6C430.2,206.2,432.8,211.3,432.8,216.4z M353.5,98v157.6c0,27.3-9.4,50.3-29,69c-19.6,19.6-42.6,29-69,29s-50.3-9.4-69-29c-19.6-19.6-29-42.6-29-69V98c0-27.3,9.4-50.3,29-69c19.6-19.6,42.6-29,69-29s50.3,9.4,69,29C344.2,47.7,353.5,71.6,353.5,98z"
                                        ></path>
                                        <!---->
                                    </svg>
                                </div>
                            </div>
                            <!---->

                            <textarea
                                placeholder="Type message"
                                class="vac-textarea"
                                style="min-height: 20px; padding-left: 12px; height: 20px"
                            ></textarea>

                            <div class="vac-icon-textarea">
                                <!---->
                                <div class="vac-wrapper">
                                    <div>
                                        <div class="vac-svg-button">
                                            <svg
                                                xmlns="http://www.w3.org/2000/svg"
                                                width="24"
                                                height="24"
                                                viewBox="0 0 24 24"
                                            >
                                                <path
                                                    id="vac-icon-emoji"
                                                    d="M11.99 2C6.47 2 2 6.48 2 12s4.47 10 9.99 10C17.52 22 22 17.52 22 12S17.52 2 11.99 2zM12 20c-4.42 0-8-3.58-8-8s3.58-8 8-8 8 3.58 8 8-3.58 8-8 8zm3.5-9c.83 0 1.5-.67 1.5-1.5S16.33 8 15.5 8 14 8.67 14 9.5s.67 1.5 1.5 1.5zm-7 0c.83 0 1.5-.67 1.5-1.5S9.33 8 8.5 8 7 8.67 7 9.5 7.67 11 8.5 11zm3.5 6.5c2.33 0 4.31-1.46 5.11-3.5H6.89c.8 2.04 2.78 3.5 5.11 3.5z"
                                                ></path>
                                                <!---->
                                            </svg>
                                        </div>
                                        <!---->
                                    </div>
                                </div>
                                <div class="vac-svg-button">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24">
                                        <path
                                            id="vac-icon-paperclip"
                                            d="M16.5,6V17.5A4,4 0 0,1 12.5,21.5A4,4 0 0,1 8.5,17.5V5A2.5,2.5 0 0,1 11,2.5A2.5,2.5 0 0,1 13.5,5V15.5A1,1 0 0,1 12.5,16.5A1,1 0 0,1 11.5,15.5V6H10V15.5A2.5,2.5 0 0,0 12.5,18A2.5,2.5 0 0,0 15,15.5V5A4,4 0 0,0 11,1A4,4 0 0,0 7,5V17.5A5.5,5.5 0 0,0 12.5,23A5.5,5.5 0 0,0 18,17.5V6H16.5Z"
                                        ></path>
                                        <!---->
                                    </svg>
                                </div>
                                <!----><input type="file" accept="*" style="display: none" />
                                <div class="vac-svg-button vac-send-disabled">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24">
                                        <path id="vac-icon-send-disabled" d="M2,21L23,12L2,3V10L17,12L2,14V21Z"></path>
                                        <!---->
                                    </svg>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
export default {
    head: {
        link: [{ href: 'https://antoine92190.github.io/vue-advanced-chat/css/app.f9790f36.css', rel: 'styleSheet' }],
        script: [
            { src: 'https://antoine92190.github.io/vue-advanced-chat/js/app.0c330f76.js' },
            { src: 'https://antoine92190.github.io/vue-advanced-chat/js/chunk-vendors.e37aa594.js' },
        ],
    },
}
</script>

<style scoped>
.vac-card-window {
    height: calc(100vh - 80px);
    --chat-color: #0a0a0a;
    --chat-bg-color-input: #fff;
    --chat-color-spinner: #333;
    --chat-color-placeholder: #9ca6af;
    --chat-color-caret: #1976d2;
    --chat-border-style: 1px solid #e1e4e8;
    --chat-bg-scroll-icon: #fff;
    --chat-container-border: none;
    --chat-container-border-radius: 4px;
    --chat-container-box-shadow: 0px 1px 2px 0px rgba(0, 0, 0, 0.14), 0px 1px 5px 0px rgba(0, 0, 0, 0.12);
    --chat-header-bg-color: #fff;
    --chat-header-color-name: #0a0a0a;
    --chat-header-color-info: #9ca6af;
    --chat-footer-bg-color: #f8f9fa;
    --chat-border-style-input: 1px solid #e1e4e8;
    --chat-border-color-input-selected: #1976d2;
    --chat-footer-bg-color-reply: #e5e5e6;
    --chat-footer-bg-color-tag-active: #e5e5e6;
    --chat-content-bg-color: #f8f9fa;
    --chat-sidemenu-bg-color: #fff;
    --chat-sidemenu-bg-color-hover: #f6f6f6;
    --chat-sidemenu-bg-color-active: #e5effa;
    --chat-sidemenu-color-active: #1976d2;
    --chat-sidemenu-border-color-search: #e1e5e8;
    --chat-dropdown-bg-color: #fff;
    --chat-dropdown-bg-color-hover: #f6f6f6;
    --chat-message-bg-color: #fff;
    --chat-message-bg-color-me: #ccf2cf;
    --chat-message-color-started: #9ca6af;
    --chat-message-bg-color-deleted: #dadfe2;
    --chat-message-color-deleted: #757e85;
    --chat-message-color-username: #9ca6af;
    --chat-message-color-timestamp: #828c94;
    --chat-message-bg-color-date: #e5effa;
    --chat-message-color-date: #505a62;
    --chat-message-bg-color-system: #e5effa;
    --chat-message-color-system: #505a62;
    --chat-message-color: #0a0a0a;
    --chat-message-bg-color-media: rgba(0, 0, 0, 0.15);
    --chat-message-bg-color-reply: rgba(0, 0, 0, 0.08);
    --chat-message-color-reply-username: #0a0a0a;
    --chat-message-color-reply-content: #6e6e6e;
    --chat-message-color-tag: #0d579c;
    --chat-message-bg-color-image: #ddd;
    --chat-message-color-new-messages: #1976d2;
    --chat-message-bg-color-scroll-counter: #0696c7;
    --chat-message-color-scroll-counter: #fff;
    --chat-message-bg-color-reaction: #eee;
    --chat-message-border-style-reaction: 1px solid #eee;
    --chat-message-bg-color-reaction-hover: #fff;
    --chat-message-border-style-reaction-hover: 1px solid #ddd;
    --chat-message-color-reaction-counter: #0a0a0a;
    --chat-message-bg-color-reaction-me: #cfecf5;
    --chat-message-border-style-reaction-me: 1px solid #3b98b8;
    --chat-message-bg-color-reaction-hover-me: #cfecf5;
    --chat-message-border-style-reaction-hover-me: 1px solid #3b98b8;
    --chat-message-color-reaction-counter-me: #0b59b3;
    --chat-message-bg-color-audio-record: #eb4034;
    --chat-message-bg-color-audio-line: rgba(0, 0, 0, 0.15);
    --chat-message-bg-color-audio-progress: #455247;
    --chat-message-bg-color-audio-progress-selector: #455247;
    --chat-markdown-bg: rgba(239, 239, 239, 0.7);
    --chat-markdown-border: rgba(212, 212, 212, 0.9);
    --chat-markdown-color: #e01e5a;
    --chat-markdown-color-multi: #0a0a0a;
    --chat-room-color-username: #0a0a0a;
    --chat-room-color-message: #67717a;
    --chat-room-color-timestamp: #a2aeb8;
    --chat-room-color-online: #4caf50;
    --chat-room-color-offline: #9ca6af;
    --chat-room-bg-color-badge: #0696c7;
    --chat-room-color-badge: #fff;
    --chat-emoji-bg-color: #fff;
    --chat-icon-color-search: #9ca6af;
    --chat-icon-color-add: #1976d2;
    --chat-icon-color-toggle: #0a0a0a;
    --chat-icon-color-menu: #0a0a0a;
    --chat-icon-color-close: #9ca6af;
    --chat-icon-color-close-image: #fff;
    --chat-icon-color-file: #1976d2;
    --chat-icon-color-paperclip: #1976d2;
    --chat-icon-color-close-outline: #000;
    --chat-icon-color-send: #1976d2;
    --chat-icon-color-send-disabled: #9ca6af;
    --chat-icon-color-emoji: #1976d2;
    --chat-icon-color-emoji-reaction: rgba(0, 0, 0, 0.3);
    --chat-icon-color-document: #1976d2;
    --chat-icon-color-pencil: #9e9e9e;
    --chat-icon-color-checkmark: #9e9e9e;
    --chat-icon-color-checkmark-seen: #0696c7;
    --chat-icon-color-eye: #fff;
    --chat-icon-color-dropdown-message: #fff;
    --chat-icon-bg-dropdown-message: rgba(0, 0, 0, 0.25);
    --chat-icon-color-dropdown-room: #9e9e9e;
    --chat-icon-color-dropdown-scroll: #0a0a0a;
    --chat-icon-color-microphone: #1976d2;
    --chat-icon-color-audio-play: #455247;
    --chat-icon-color-audio-pause: #455247;
    --chat-icon-color-audio-cancel: #eb4034;
    --chat-icon-color-audio-confirm: #1ba65b;
}
</style>
