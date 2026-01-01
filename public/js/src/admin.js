/******************************************************************************
 * SYSTEM
 *****************************************************************************/

import initDashboard from './admin/system/dashboard.js'
initDashboard();

import { initBaloonEditor, initSimpleEditor } from './admin/system/ckEditor.js';
initBaloonEditor();
initSimpleEditor();

import uploadAvatar from './admin/system/avatar.js'
uploadAvatar();

import initEditContent from './admin/system/editContent.js'
initEditContent();

/******************************************************************************
 * COMPONENTS
 *****************************************************************************/

import initModals from './admin/components/modals.js'
initModals();

