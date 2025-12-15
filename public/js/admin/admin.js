/******************************************************************************
 * SYSTEM
 *****************************************************************************/

import initDashboard from './system/dashboard.js'
initDashboard();

import { initBaloonEditor, initSimpleEditor } from './system/ckEditor.js';
initBaloonEditor();
initSimpleEditor();

import uploadAvatar from './system/avatar.js'
uploadAvatar();

import initEditContent from './system/editContent.js'
initEditContent();

/******************************************************************************
 * COMPONENTS
 *****************************************************************************/

import initModals from './components/modals.js'
initModals();

