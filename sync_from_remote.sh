#!/bin/bash

source secret.sh
    #SSH_PORT
    #REMOTE_URL
    #REMOTE_DIR_PATH
    #LOCAL_DIR_PATH

rsync --dry-run -azivh -e "ssh -p ${SSH_PORT}" ${REMOTE_URL}:${REMOTE_DIR_PATH}/page-special.php  ${LOCAL_DIR_PATH}/page-special.php
#rsync -azivh -e "ssh -p ${SSH_PORT}" ${REMOTE_URL}:${REMOTE_DIR_PATH}/page-special.php  ${LOCAL_DIR_PATH}/page-special.php

rsync --dry-run -azivh -e "ssh -p ${SSH_PORT}" ${REMOTE_URL}:${REMOTE_DIR_PATH}/page-full-width-special.php ${LOCAL_DIR_PATH}/page-full-width-special.php
#rsync -azivh -e "ssh -p ${SSH_PORT}" ${REMOTE_URL}:${REMOTE_DIR_PATH}/page-full-width-special.php ${LOCAL_DIR_PATH}/page-full-width-special.php
#rsync -azivh -e "ssh -p ${SSH_PORT}" ${REMOTE_URL}:${REMOTE_DIR_PATH}/page-full-width-special.php ${LOCAL_DIR_PATH}/bu/

rsync --dry-run -azivh -e "ssh -p ${SSH_PORT}" ${REMOTE_URL}:${REMOTE_DIR_PATH}/page-full-width-nar-vis-project.php ${LOCAL_DIR_PATH}/page-full-width-nar-vis-project.php
#rsync -azivh -e "ssh -p ${SSH_PORT}" ${REMOTE_URL}:${REMOTE_DIR_PATH}/page-full-width-nar-vis-project.php ${LOCAL_DIR_PATH}/page-full-width-nar-vis-project.php
