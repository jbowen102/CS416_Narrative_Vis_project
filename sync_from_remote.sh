#!/bin/bash

source secret.sh
    #SSH_PORT
    #REMOTE_URL
    #REMOTE_DIR_PATH
    #LOCAL_DIR_PATH

rsync -azivh -e "ssh -p ${SSH_PORT}" ${REMOTE_URL}:${REMOTE_DIR_PATH}/page-full-width-special.php ${LOCAL_DIR_PATH}/page-full-width-special.php
rsync -azivh -e "ssh -p ${SSH_PORT}" ${REMOTE_URL}:${REMOTE_DIR_PATH}/page-special.php  ${LOCAL_DIR_PATH}/page-special.php
