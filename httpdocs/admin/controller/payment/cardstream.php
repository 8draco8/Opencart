<?php

	class ControllerPaymentCardstream extends Controller {

		private $error = array();

		public function index() {

			$this->load->language( 'payment/cardstream' );

			$this->document->setTitle( $this->language->get( 'heading_title' ) );

			$this->load->model( 'setting/setting' );

			if ( ( $this->request->server['REQUEST_METHOD'] == 'POST' ) && $this->validate() ) {

				$this->model_setting_setting->editSetting( 'cardstream', $this->request->post );

				$this->session->data['success'] = $this->language->get( 'text_success' );

				$this->redirect( $this->url->link( 'extension/payment',
					'token=' . $this->session->data['token'], 'SSL' ) );

			}

			$this->data['heading_title'] = $this->language->get( 'heading_title' );

			$this->data['text_enabled']    = $this->language->get( 'text_enabled' );
			$this->data['text_disabled']   = $this->language->get( 'text_disabled' );
			$this->data['text_all_zones']  = $this->language->get( 'text_all_zones' );
			$this->data['text_yes']        = $this->language->get( 'text_yes' );
			$this->data['text_no']         = $this->language->get( 'text_no' );
			$this->data['text_live']       = $this->language->get( 'text_live' );
			$this->data['text_successful'] = $this->language->get( 'text_successful' );
			$this->data['text_fail']       = $this->language->get( 'text_fail' );

			$this->data['entry_merchantid']     = $this->language->get( 'entry_merchantid' );
			$this->data['entry_merchantsecret'] = $this->language->get( 'entry_merchantsecret' );
			$this->data['entry_order_status']   = $this->language->get( 'entry_order_status' );
			$this->data['entry_geo_zone']       = $this->language->get( 'entry_geo_zone' );
			$this->data['entry_status']         = $this->language->get( 'entry_status' );
			$this->data['entry_sort_order']     = $this->language->get( 'entry_sort_order' );

			$this->data['entry_currencycode'] = $this->language->get( 'entry_currencycode' );
			$this->data['entry_countrycode']  = $this->language->get( 'entry_countrycode' );

			$this->data['button_save']   = $this->language->get( 'button_save' );
			$this->data['button_cancel'] = $this->language->get( 'button_cancel' );

			if ( isset( $this->error['warning'] ) ) {

				$this->data['error_warning'] = $this->error['warning'];

			} else {

				$this->data['error_warning'] = '';

			}

			if ( isset( $this->error['merchantid'] ) ) {

				$this->data['error_merchantid'] = $this->error['merchantid'];

			} else {

				$this->data['error_merchantid'] = '';

			}

			if ( isset( $this->error['merchantsecret'] ) ) {

				$this->data['error_merchantsecret'] = $this->error['merchantsecret'];

			} else {

				$this->data['error_merchantsecret'] = '';

			}

			if ( isset( $this->error['currencycode'] ) ) {

				$this->data['error_currencycode'] = $this->error['currencycode'];

			} else {

				$this->data['error_currencycode'] = '';

			}

			if ( isset( $this->error['countrycode'] ) ) {

				$this->data['error_countrycode'] = $this->error['countrycode'];

			} else {

				$this->data['error_countrycode'] = '';

			}

			$this->data['breadcrumbs'] = array();

			$this->data['breadcrumbs'][] = array(
				'text'      => $this->language->get( 'text_home' ),
				'href'      => $this->url->link( 'common/home', 'token=' . $this->session->data['token'], 'SSL' ),
				'separator' => false
			);

			$this->data['breadcrumbs'][] = array(
				'text'      => $this->language->get( 'text_payment' ),
				'href'      => $this->url->link( 'extension/payment', 'token=' . $this->session->data['token'], 'SSL' ),
				'separator' => ' :: '
			);

			$this->data['breadcrumbs'][] = array(
				'text'      => $this->language->get( 'heading_title' ),
				'href'      => $this->url->link( 'payment/cardstream',
						'token=' . $this->session->data['token'], 'SSL' ),
				'separator' => ' :: '
			);

			$this->data['action'] =
				$this->url->link( 'payment/cardstream', 'token=' . $this->session->data['token'], 'SSL' );

			$this->data['cancel'] =
				$this->url->link( 'extension/payment', 'token=' . $this->session->data['token'], 'SSL' );

			if ( isset( $this->request->post['cardstream_merchantid'] ) ) {

				$this->data['cardstream_merchantid'] = $this->request->post['cardstream_merchantid'];

			} else {

				$this->data['cardstream_merchantid'] = $this->config->get( 'cardstream_merchantid' );

			}

			if ( isset( $this->request->post['cardstream_merchantsecret'] ) ) {

				$this->data['cardstream_merchantsecret'] = $this->request->post['cardstream_merchantsecret'];

			} else {

				$this->data['cardstream_merchantsecret'] = $this->config->get( 'cardstream_merchantsecret' );

			}

			if ( isset( $this->request->post['cardstream_order_status_id'] ) ) {

				$this->data['cardstream_order_status_id'] = $this->request->post['cardstream_order_status_id'];

			} else {

				$this->data['cardstream_order_status_id'] = $this->config->get( 'cardstream_order_status_id' );

			}

			$this->load->model( 'localisation/order_status' );

			$this->data['order_statuses'] = $this->model_localisation_order_status->getOrderStatuses();

			if ( isset( $this->request->post['cardstream_geo_zone_id'] ) ) {

				$this->data['cardstream_geo_zone_id'] = $this->request->post['cardstream_geo_zone_id'];

			} else {

				$this->data['cardstream_geo_zone_id'] = $this->config->get( 'cardstream_geo_zone_id' );

			}

			$this->load->model( 'localisation/geo_zone' );

			$this->data['geo_zones'] = $this->model_localisation_geo_zone->getGeoZones();

			if ( isset( $this->request->post['cardstream_status'] ) ) {

				$this->data['cardstream_status'] = $this->request->post['cardstream_status'];

			} else {

				$this->data['cardstream_status'] = $this->config->get( 'cardstream_status' );

			}

			if ( isset( $this->request->post['cardstream_sort_order'] ) ) {

				$this->data['cardstream_sort_order'] = $this->request->post['cardstream_sort_order'];

			} else {

				$this->data['cardstream_sort_order'] = $this->config->get( 'cardstream_sort_order' );

			}

			if ( isset( $this->request->post['cardstream_currencycode'] ) ) {

				$this->data['cardstream_currencycode'] = $this->request->post['cardstream_currencycode'];

			} else {

				$this->data['cardstream_currencycode'] = $this->config->get( 'cardstream_currencycode' );

			}

			if ( isset( $this->request->post['cardstream_countrycode'] ) ) {

				$this->data['cardstream_countrycode'] = $this->request->post['cardstream_countrycode'];

			} else {

				$this->data['cardstream_countrycode'] = $this->config->get( 'cardstream_countrycode' );

			}

			$this->template = 'payment/cardstream.tpl';

			$this->children = array(
				'common/header',
				'common/footer'
			);

			$this->response->setOutput( $this->render() );

		}

		private function validate() {

			if ( !$this->user->hasPermission( 'modify', 'payment/cardstream' ) ) {

				$this->error['warning'] = $this->language->get( 'error_permission' );

			}

			if ( !$this->request->post['cardstream_merchantid'] ) {

				$this->error['merchantid'] = $this->language->get( 'error_merchantid' );

			}

			if ( !$this->request->post['cardstream_merchantsecret'] ) {

				$this->error['merchantsecret'] = $this->language->get( 'error_merchantsecret' );

			}

			if ( ( !$this->request->post['cardstream_currencycode'] ) ||
				 ( !is_numeric( $this->request->post['cardstream_currencycode'] ) )
			) {

				$this->error['currencycode'] = $this->language->get( 'error_currencycode' );

			}

			if ( ( !$this->request->post['cardstream_countrycode'] ) ||
				 ( !is_numeric( $this->request->post['cardstream_countrycode'] ) )
			) {

				$this->error['countrycode'] = $this->language->get( 'error_countrycode' );

			}

			if ( !$this->error ) {

				return true;

			} else {

				return false;

			}

		}

	}