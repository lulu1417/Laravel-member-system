<?php

namespace App\Http\Controllers;

use App\Http\Controllers\BaseController as BaseController;
use App\Member;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Str;
use Validator;

class MemberController extends BaseController {
	/**
	 * Display a listing of the resource.
	 * @param \Illuminate\Http\Request $request
	 * @return \Illuminate\Http\Response
	 */
	public function index() {
		$admins = Member::all();
		$members = [
			'mail' => Auth::user()->email,
			'password' => Auth::user()->password,
		];
		if (Auth::user()->isAdmin) {
			return $this->sendResponse($admins->toArray(), 'Members retrieved successfully.');
		} else {
			return $members;
		}

	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @param \Illuminate\Http\Request $request
	 * @return \Illuminate\Http\Response
	 */
	public function store(Request $request) {
		try {
			$request->validate([
				'email' => ['required', 'string', 'email', 'max:255', 'unique:members'],
				'password' => ['required', 'string', 'min:6', 'max:12'],
			]);

			$apiToken = Str::random(10);
			$create = Member::create([
				'email' => $request['email'],
				'password' => $request['password'],
				'api_token' => $apiToken,
			]);

			if ($create) {
				return "Your api token is $apiToken";
			}

		} catch (Exception $e) {
			dd($e);

		}

	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param \Illuminate\Http\Request $request
	 * @param \App\Member $members
	 * @return \Illuminate\Http\Response
	 */
	public function update(Request $request) {

		$input = $request->all();
		$validator = Validator::make($input, [
			'email' => ['string', 'email', 'max:255', 'unique:members'],
			'password' => ['string', 'min:6', 'max:12'],
		]);

		if ($validator->fails()) {
			return $this->sendError('Validation Error.', $validator->errors());
		}
		$member = Auth::user();
		if ($member->update($request->all())) {
			return $this->sendResponse($member->toArray(), 'Member updated successfully.');
		}

	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param \App\Member $members
	 * @return \Illuminate\Http\Response
	 */
	public function destroy(Member $members) {
		if (Auth::user()->isAdmin) {
			if ($members->delete()) {
				return $this->sendResponse($members->toArray(), 'Member deleted successfully.');
			}

		} else {
			return "You have no authority to delete";
		}

	}
}
