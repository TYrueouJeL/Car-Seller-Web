<?php

namespace App\Controller;

use App\Entity\Images;
use App\Repository\ImagesRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\String\Slugger\SluggerInterface;

final class ImagesController extends AbstractController
{
    #[Route('/api/images', name: 'app_images')]
    public function list(ImagesRepository $imagesRepository): JsonResponse
    {
        $images = $imagesRepository->findAll();

        $data = array_map(fn(Images $img) => [
            'id'           => $img->getId(),
            'filename'     => $img->getFilename(),
            'originalName' => $img->getOriginalName(),
            'url'          => $this->getParameter('app.base_url') . '/uploads/images/' . $img->getFilename(),
            'uploadedAt'   => $img->getUploadedAt()->format('Y-m-d H:i:s'),
        ], $images);

        return $this->json($data);
    }

    #[Route('/api/images/upload', name: 'app_images_upload', methods: ['POST'])]
    public function upload(ImagesRepository $imagesRepository, Request $request, EntityManagerInterface $entityManager, SluggerInterface $slugger): JsonResponse
    {
        $file = $request->files->get('file');

        if (!$file) {
            return $this->json(['error' => 'No file uploaded'], 400);
        }

        $allowedMimes = ['image/jpeg', 'image/png', 'image/gif'];
        if (!in_array($file->getMimeType(), $allowedMimes)) {
            return $this->json(['error' => 'Invalid file type'], 400);
        }

        if ($file->getSize() > 1024 * 1024 * 5) {
            return $this->json(['error' => 'File size exceeds 5MB'], 400);
        }

        $originalName = $file->getClientOriginalName();
        $safeFileName = $slugger->slug(pathinfo($originalName, PATHINFO_FILENAME));
        $newFileName = $safeFileName . '-' . uniqid() . '.' . $file->guessExtension();

        $uploadDir = $this->getParameter('kernel.project_dir') . '/public/uploads/images';
        $file->move($uploadDir, $newFileName);

        $image = new Images();
        $image->setFilename($newFileName);
        $image->setOriginalName($originalName);
        $image->setUploadedAt(new \DateTimeImmutable());

        $entityManager->persist($image);
        $entityManager->flush();

        return $this->json([
            'id'           => $image->getId(),
            'filename'     => $newFileName,
            'url'          => $this->getParameter('app.base_url') . '/uploads/images/' . $newFileName,
            'uploadedAt'   => $image->getUploadedAt()->format('Y-m-d H:i:s'),
        ], Response::HTTP_CREATED);
    }

    #[Route('/api/images/{id}', name: 'app_images_delete', methods: ['DELETE'])]
    public function delete(Images $images, EntityManagerInterface $entityManager): JsonResponse
    {
        $filePath = $this->getParameter('kernel.project_dir') . '/public/uploads/images/' . $images->getFilename();

        if (file_exists($filePath)) {
            unlink($filePath);
        }

        $entityManager->remove($images);
        $entityManager->flush();

        return $this->json(['message' => 'Image deleted successfully']);
    }
}
